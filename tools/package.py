#!/usr/bin/env python3
"""Build deterministic installable/source ZIPs from the release tree."""
from pathlib import Path
import hashlib, re, sys, zipfile
root = Path(__file__).resolve().parents[1]
out = Path(sys.argv[1] if len(sys.argv) > 1 else root / 'dist').resolve()
out.mkdir(parents=True, exist_ok=True)
version = re.search(r'Version:\s*(\d+\.\d+\.\d+)', (root/'multisite-toolbar-additions.php').read_text()).group(1)
explicit = {'multisite-toolbar-additions.php','index.php','LICENSE','README.md','README-de.md','readme.txt','readme-de.txt','composer.json','changelog-archive.md'}
styles = {'editor.css','toolbar.css','settings.css','settings.js','deckerweb-footer.css','deckerweb-footer.js'}
files = sorted(p for p in root.rglob('*') if p.is_file() and '.git' not in p.relative_to(root).parts and out not in p.parents and p.relative_to(root).parts[0] != 'dist')
for source in (False, True):
    target = out / ('multisite-toolbar-additions-'+version+('-source' if source else '')+'.zip')
    with zipfile.ZipFile(target, 'w', compression=zipfile.ZIP_DEFLATED, compresslevel=9) as archive:
        for path in files:
            rel = path.relative_to(root)
            if not source and not (str(rel) in explicit or rel.parts[0] in ('src','includes','languages','docs') or rel.parts[:2] == ('assets','brand') or (rel.parts[0] == 'assets' and path.name in styles)):
                continue
            entry = zipfile.ZipInfo('multisite-toolbar-additions/'+rel.as_posix(), (2026,10,1,0,0,0))
            entry.compress_type = zipfile.ZIP_DEFLATED
            entry.external_attr = 0o100644 << 16
            archive.writestr(entry, path.read_bytes(), compresslevel=9)
    with zipfile.ZipFile(target) as archive:
        assert archive.testzip() is None
        for required in ('multisite-toolbar-additions.php','includes/deckerweb-github-release-updater-v2.php','includes/deckerweb-plugin-library/bootstrap.php','docs/wiki/FAQ-Deutsch.md'):
            assert 'multisite-toolbar-additions/'+required in archive.namelist()
    print(target.name, target.stat().st_size)
(out/'SHA256SUMS').write_text(''.join(hashlib.sha256(p.read_bytes()).hexdigest()+'  '+p.name+'\n' for p in sorted(out.glob('multisite-toolbar-additions-'+version+'*.zip')) if 'preview' not in p.name and 'branding' not in p.name))
