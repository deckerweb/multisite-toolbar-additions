#!/usr/bin/env python3
"""Prepare local Wiki Markdown with absolute links; never publish or push it."""
from pathlib import Path
import re,sys
root=Path(__file__).resolve().parents[1]
output=Path(sys.argv[1]).resolve();output.mkdir(parents=True,exist_ok=True)
base='https://github.com/deckerweb/multisite-toolbar-additions/wiki/'
for path in (root/'docs/wiki').glob('*.md'):
 text=re.sub(r'\]\((?:\./)?([^/)#]+)\.md(#[^)]*)?\)',lambda m:']('+base+m[1]+(m[2] or '')+')',path.read_text())
 (output/path.name).write_text(text)
print('Prepared 8 local Wiki pages; no remote changes.')
