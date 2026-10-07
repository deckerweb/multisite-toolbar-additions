#!/usr/bin/env python3
"""Build host POT/PO/MO resources from the maintained bilingual dictionary."""
from pathlib import Path
import json,subprocess
r=Path(__file__).resolve().parents[1]
messages=json.loads((r/'languages/messages.json').read_text())
q=lambda s:json.dumps(s,ensure_ascii=False)
for locale in ['', 'de_DE','de_DE_formal']:
 header='Project-Id-Version: Multisite Toolbar Additions '+json.loads((r/'docs/content.json').read_text())['version']+'\nReport-Msgid-Bugs-To: https://github.com/deckerweb/multisite-toolbar-additions/issues\nPOT-Creation-Date: 2026-10-07 12:00+0200\nPO-Revision-Date: 2026-10-07 12:00+0200\nLast-Translator: David Decker – DECKERWEB\nLanguage-Team: German\nMIME-Version: 1.0\nContent-Type: text/plain; charset=UTF-8\nContent-Transfer-Encoding: 8bit\n'
 if locale:header+='Language: '+locale+'\nPlural-Forms: nplurals=2; plural=(n != 1);\n'
 lines=['# Copyright © 2012–2026 David Decker – DECKERWEB. GPL-2.0-or-later.','msgid ""','msgstr '+q(header),'']
 for text,translations in messages.items():
  lines+=['msgid '+q(text)]
  if text=='%d child level':lines+=['msgid_plural "%d child levels"','msgstr[0] '+q(translations[locale] if locale else ''),'msgstr[1] '+q('%d Kindebenen' if locale else '')]
  else:lines+=['msgstr '+q(translations[locale] if locale else '')]
  lines+=['']
 base=r/'languages'/('multisite-toolbar-additions'+('-'+locale if locale else ''))
 base.with_suffix('.po' if locale else '.pot').write_text('\n'.join(lines).rstrip()+'\n')
 if locale:subprocess.run(['msgfmt','--check','-o',str(base.with_suffix('.mo')),str(base.with_suffix('.po'))],check=True)
print(str(len(messages))+' messages built for informal and formal German.')
