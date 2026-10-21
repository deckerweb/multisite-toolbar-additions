#!/usr/bin/env python3
"""Build deterministic deployment/source archives, or one explicitly named validation ZIP."""
from pathlib import Path
import argparse,hashlib,re,zipfile
parser=argparse.ArgumentParser(description=__doc__)
parser.add_argument('output',nargs='?')
parser.add_argument('--validation',action='store_true',help='Build a local test package without release/source artifacts.')
args=parser.parse_args()
root=Path(__file__).resolve().parents[1]
out=Path(args.output or root/'dist').resolve();out.mkdir(parents=True,exist_ok=True)
version=re.search(r'Version:\s*(\d+\.\d+\.\d+)',(root/'multisite-toolbar-additions.php').read_text()).group(1)
explicit={'multisite-toolbar-additions.php','uninstall.php','index.php','LICENSE','readme.txt','readme-de.txt','readme-de-formal.txt','SECURITY.md','SECURITY-de.md'}
styles={'upload.css','upload.js','editor.css','toolbar.css','settings.css','settings.js','deckerweb-footer.css','deckerweb-footer.js'}
brand={'FONT-LICENSE.txt','icon.svg','icon-128x128.png','icon-256x256.png',*[f'banner-{lang}-{size}.png' for lang in ('en','de') for size in ('772x250','1544x500')]}
docs={'changelog.txt','changelog-de.txt','changelog-full.txt','changelog-full-de.txt',*[f'{name}{suffix}.md' for name in ('LIBRARIES','DATA','MIGRATION-4.0','RELEASE-POLICY','GLOSSARY') for suffix in ('','-de')]}
files=sorted(p for p in root.rglob('*') if p.is_file() and not set(p.relative_to(root).parts)&{'.git','__pycache__','dist'} and out not in p.parents and p.name!='.DS_Store')
built=[]
for source in (False,) if args.validation else (False,True):
 name='multisite-toolbar-additions-validation.zip' if args.validation else 'multisite-toolbar-additions-'+version+('-source' if source else '')+'.zip'
 target=out/name
 with zipfile.ZipFile(target,'w',compression=zipfile.ZIP_DEFLATED,compresslevel=9) as archive:
  for path in files:
   rel=path.relative_to(root)
   runtime=(str(rel) in explicit or rel.parts[0] in ('src','includes') or (rel.parts[0]=='languages' and path.suffix in ('.php','.po','.mo','.pot')) or (rel.parts[0]=='docs' and (rel.name in docs or rel.parts[:2]==('docs','wiki'))) or (rel.parts[:2]==('assets','brand') and path.name in brand) or (rel.parts[0]=='assets' and path.name in styles))
   if not source and not runtime:continue
   entry=zipfile.ZipInfo('multisite-toolbar-additions/'+rel.as_posix(),(2026,10,1,0,0,0));entry.compress_type=zipfile.ZIP_DEFLATED;entry.external_attr=0o100644<<16
   archive.writestr(entry,path.read_bytes(),compresslevel=9)
 with zipfile.ZipFile(target) as archive:
  assert archive.testzip() is None
  for required in ('multisite-toolbar-additions.php','uninstall.php','includes/deckerweb-github-release-updater-v2.php','includes/deckerweb-plugin-library/bootstrap.php','includes/deckerweb-plugin-library/lifecycle.php','docs/wiki/FAQ-Deutsch.md'):
   assert 'multisite-toolbar-additions/'+required in archive.namelist()
 built.append(target);print(target.name,target.stat().st_size)
(out/('VALIDATION-SHA256SUMS' if args.validation else 'SHA256SUMS')).write_text(''.join(hashlib.sha256(p.read_bytes()).hexdigest()+'  '+p.name+'\n' for p in built))
