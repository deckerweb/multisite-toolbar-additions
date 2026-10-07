#!/usr/bin/env python3
"""Generate public EN/DE readmes, topic FAQ and release history from content.json."""
from pathlib import Path
import json,re
root=Path(__file__).resolve().parents[1]
data=json.loads((root/'docs/content.json').read_text())
repo='https://github.com/deckerweb/multisite-toolbar-additions'
labels={'New':'Neu','Improved':'Verbessert','Fixed':'Behoben','Misc':'Sonstiges'}
def changes(lang,entries=None,wp=False):
 """Format selected bilingual release records for Markdown or WordPress text."""
 result=[]
 for release in entries or data['releases']:
  heading=release['version']+' · '+release['date']
  result.append(('= '+heading+' =' if wp else '### '+heading)+'\n')
  for item in sorted(release['items'],key=lambda i:list(labels).index(i['category'])):
   prefix=labels[item['category']] if lang=='de' else item['category']
   result.append(('* '+prefix+': ' if wp else '- **'+prefix+':** ')+item[lang])
  result.append('')
 return '\n'.join(result)
features=data['features']
intro=data['intro']
install=data['install']
groups=data['groups']
short=[0,2,4,7,8,13,19]
for lang in ['en','de']:
 de=lang=='de'; suffix='-de' if de else '';guide='Deutsch' if de else 'English'
 faqtitle='Fragen nach Themen' if de else 'FAQ by topic'
 faq='# '+faqtitle+'\n\n[English](FAQ-English.md) · [Deutsch](FAQ-Deutsch.md) · [Home](Home.md)\n\n'+data['scope'][lang]+'\n\n'
 for group,title in groups[lang].items():
  faq+='## '+title+'\n\n'
  for item in data['faq']:
   if item['group']==group:faq+='### '+item[lang]['question']+'\n\n'+item[lang]['answer']+'\n\n'
 (root/'docs/wiki'/('FAQ-Deutsch.md' if de else 'FAQ-English.md')).write_text(faq)
 full='# '+('Änderungsverlauf' if de else 'Changelog')+'\n\n[English](CHANGELOG.md) · [Deutsch](CHANGELOG-de.md)\n\n'+changes(lang)
 (root/'docs'/('CHANGELOG-de.md' if de else 'CHANGELOG.md')).write_text(full)
 wiki=full.replace('(CHANGELOG.md)','(Changelog-English.md)').replace('(CHANGELOG-de.md)','(Changelog-Deutsch.md)')
 (root/'docs/wiki'/('Changelog-Deutsch.md' if de else 'Changelog-English.md')).write_text(wiki)
 (root/'docs'/('changelog-de.txt' if de else 'changelog.txt')).write_text(changes(lang,data['releases'][:7],wp=True))
 (root/'docs'/('changelog-full-de.txt' if de else 'changelog-full.txt')).write_text(changes(lang,wp=True))
 titles=['Kurzvorstellung','Auf einen Blick','Installation und erste Schritte','Hauptfunktionen','FAQ','Changelog','Über das Projekt','Hilfe und Sicherheit','Lizenz und Herkunft'] if de else ['About','At a glance','Installation and first steps','Main features','FAQ','Changelog','Project','Support and security','License and credits']
 def anchor(t):return t.lower().replace(' ','-')
 top='# Multisite Toolbar Additions\n\n![Multisite Toolbar Additions](assets-github/banner-'+lang+'-1280x640.png)\n\n## '+titles[0]+'\n\n**'+('Viele Sites. Ein Handgriff.' if de else 'Many sites. One move.')+'**\n\n'+'**'+data['scope'][lang]+'**\n\n'+intro[lang]+'\n\n'+data['about_history'][lang]+'\n\n**Version '+data['version']+' · WordPress 6.7+ · PHP 8.2+**\n\n'+data['working_tree'][lang]+'\n\n'
 top+='[English](README.md) · [Deutsch](README-de.md) · [Download]('+repo+'/releases/latest) · ['+faqtitle+']('+repo+'/wiki/FAQ-'+guide+')\n\n'
 top+='## '+('Inhalt' if de else 'Contents')+'\n\n'+' · '.join('['+x+'](#'+anchor(x)+')' for x in titles[1:5]+['Screenshots']+titles[5:])+'\n\n'
 top+='## '+titles[1]+'\n\n'+'\n'.join('- '+v for k,v in features[lang])+'\n\n## '+titles[2]+'\n\n'+install[lang]+'\n\n## '+titles[3]+'\n\n'
 for k,v in features[lang]:top+='### '+k+'\n\n'+v+'\n\n'
 top+='## '+titles[4]+'\n\n'
 for i in short:top+='### '+data['faq'][i][lang]['question']+'\n\n'+data['faq'][i][lang]['answer']+'\n\n'
 top+='['+faqtitle+']('+repo+'/wiki/FAQ-'+guide+')\n\n## Screenshots\n\n'
 for shot in data['screenshots']:top+='!['+shot[lang]+'](assets/screenshots/'+shot['file']+'-'+lang+'.png)\n\n'+shot[lang]+'\n\n'
 top+='## '+titles[5]+'\n\n'
 if data['unreleased']:
  top+='### '+('Noch nicht veröffentlicht' if de else 'Unreleased')+'\n\n'
  for item in data['unreleased']:top+='- **'+(labels[item['category']] if de else item['category'])+':** '+item[lang]+'\n'
 top+='\n'+changes(lang,data['releases'][:7])+'\n['+('Vollständiger Verlauf' if de else 'Full history')+'](docs/CHANGELOG'+suffix+'.md)\n\n'
 top+='## '+titles[6]+'\n\n'+('David Decker entwickelt und pflegt dieses Plugin seit 2012. Die Serie QuickNav erleichtert die tägliche WordPress-Verwaltung. Der gewachsene Pluginname bleibt erhalten.' if de else 'David Decker has developed and maintained this plugin since 2012. The QuickNav family shortens everyday WordPress administration. Its established name is retained.')+'\n\n'
 top+='## '+titles[7]+'\n\n[Issues]('+repo+'/issues) · [Discussions]('+repo+'/discussions) · ['+('Sicherheitsmeldungen' if de else 'Security reporting')+'](SECURITY'+suffix+'.md)\n\n[Ko-fi](https://ko-fi.com/deckerweb) · [Buy Me a Coffee](https://buymeacoffee.com/daveshine) · [PayPal](https://paypal.me/deckerweb)\n\n'
 top+='## '+titles[8]+'\n\n© 2012–2026 David Decker – DECKERWEB. [GPL v2 or later](LICENSE).\n\n'+('Library und Updater: David Decker, GPL-2.0-or-later. Footer und Änderungsverlauf basieren auf den öffentlichen deckerweb Referenzplugins. Launch-Rail-Grafiken: David Decker, GPL-2.0-or-later; lokale Systemschriften. Quellen und Komponentenstände: [Gemeinsame Komponenten](docs/LIBRARIES-de.md).' if de else 'Library and Updater: David Decker, GPL-2.0-or-later. Footer and release history are based on public deckerweb reference plugins. Launch Rail artwork: David Decker, GPL-2.0-or-later; local system fonts. Sources and component versions: [Shared components](docs/LIBRARIES.md).')+'\n'
 (root/('README-de.md' if de else 'README.md')).write_text(top)
 # Directory-compatible format remains available for this direct-distribution plugin.
 txt='=== Multisite Toolbar Additions ===\nContributors: ddecker\nDonate link: https://paypal.me/deckerweb\nTags: toolbar, admin bar, multisite, navigation\nRequires at least: 6.7\nTested up to: 7.1\nRequires PHP: 8.2\nStable tag: '+data['version']+'\nLicense: GPLv2 or later\nLicense URI: https://www.gnu.org/licenses/gpl-2.0.html\n\n'+('WordPress-Menüs und Verwaltungsverknüpfungen in der Toolbar.' if de else 'WordPress menus and useful administration shortcuts in the toolbar.')+'\n\n== Description ==\n\n'+'**'+data['scope'][lang]+'**\n\n'+intro[lang]+'\n\n'+data['about_history'][lang]+'\n\n'+data['working_tree'][lang]+'\n\n'+'\n'.join('* '+v for k,v in features[lang])+'\n\n== Installation ==\n\n'+install[lang]+'\n\n== Frequently Asked Questions ==\n\n'
 for i in short:txt+='= '+data['faq'][i][lang]['question']+' =\n\n'+data['faq'][i][lang]['answer']+'\n\n'
 txt+=faqtitle+': '+repo+'/wiki/FAQ-'+guide+'\n\n== Changelog ==\n\n'+changes(lang,data['releases'][:7],wp=True)+'\n== Upgrade Notice ==\n\n= '+data['version']+' =\n'+('ZIP-Upload-Seiten und Menüvorschau ergänzt. Beide ZIP-Admin-Untermenüs sind standardmäßig aktiv; der Theme-Eintrag unter Neu bleibt standardmäßig aus. Einstellungen und WordPress-Menüs bleiben erhalten. WordPress 6.7/PHP 8.2 weiterhin erforderlich.' if de else 'Adds ZIP upload pages and menu previews. Both ZIP admin submenu links default to enabled; the Theme addition under New remains disabled by default. Settings and WordPress menus are retained. WordPress 6.7/PHP 8.2 requirements are unchanged.')+'\n\n== Credits ==\n\nDavid Decker – DECKERWEB, GPL-2.0-or-later.\n'+repo+'/blob/master/docs/LIBRARIES'+suffix+'.md\n'
 (root/('readme-de.txt' if de else 'readme.txt')).write_text(txt)
 if de:
  formal=txt
  for source,target in [('Dein WordPress-Menü','Ihr WordPress-Menü'),('Wähle ','Wählen Sie '),('Zeige ','Zeigen Sie '),('gruppiere sie','gruppieren Sie sie'),('Prüfe ','Prüfen Sie '),('Installiere ','Installieren Sie '),('Öffne ','Öffnen Sie '),('verwende ','verwenden Sie '),('Erstelle ','Erstellen Sie '),('und wähle ','und wählen Sie '),('Aktiviere ','Aktivieren Sie ')]:
   formal=formal.replace(source,target)
  (root/'readme-de-formal.txt').write_text(formal)

 guide_text='# '+('Anleitung' if de else 'Guide')+'\n\n[English](English.md) · [Deutsch](Deutsch.md) · ['+faqtitle+'](FAQ-'+guide+'.md) · [Home](Home.md)\n\n'+'**'+data['scope'][lang]+'**\n\n'+intro[lang]+'\n\n'+data['about_history'][lang]+'\n\n'+data['working_tree'][lang]+'\n\n## '+titles[2]+'\n\n'+install[lang]+'\n\n'
 for k,v in features[lang]:guide_text+='## '+k+'\n\n'+v+'\n\n'
 guide_text+='## '+('Daten und Berechtigungen' if de else 'Data and permissions')+'\n\n'+data['faq'][19][lang]['answer']+'\n\n'+data['faq'][7][lang]['answer']+'\n\n'
 (root/'docs/wiki'/(guide+'.md')).write_text(guide_text)
(root/'docs/wiki/Home.md').write_text('# Multisite Toolbar Additions · Documentation / Dokumentation\n\n![Multisite Toolbar Additions]('+repo+'/raw/master/assets-github/banner-en-1280x640.png)\n\n**Many sites. One move. · Viele Sites. Ein Handgriff.**\n\nFor single WordPress sites and Multisite networks — both supported since 2012. A configurable toolbar menu with site/network shortcuts. Choose a language for setup, menu positioning, ZIP uploads, permissions and updates.\nFür einzelne WordPress-Websites und Multisite-Netzwerke — beide seit 2012 unterstützt. Ein konfigurierbares Toolbar-Menü mit Website-/Netzwerk-Verknüpfungen. Wähle eine Sprache für Einrichtung, Menüposition, ZIP-Uploads, Berechtigungen und Updates.\n\n| English | Deutsch |\n| --- | --- |\n| [Guide](English.md) | [Anleitung](Deutsch.md) |\n| [Your toolbar menu](English.md#your-wordpress-menu) | [Dein Toolbar-Menü](Deutsch.md#dein-wordpress-menü) |\n| [Upload shortcuts](English.md#upload-shortcuts) | [Upload-Verknüpfungen](Deutsch.md#upload-verknüpfungen) |\n| [FAQ by topic](FAQ-English.md) | [Fragen nach Themen](FAQ-Deutsch.md) |\n| [Full changelog](Changelog-English.md) | [Vollständiger Änderungsverlauf](Changelog-Deutsch.md) |\n\n[Download]('+repo+'/releases/latest) · [Issues]('+repo+'/issues) · [Private security reports / Private Sicherheitsmeldungen]('+repo+'/security/advisories/new)\n\n© 2012–2026 David Decker – DECKERWEB · GPL v2 or later\n')
(root/'docs/wiki/_Sidebar.md').write_text('**Multisite Toolbar Additions**\n\n[Home](Home.md) · [Download]('+repo+'/releases/latest)\n\n**English**\n\n- [Guide](English.md)\n- [Your toolbar menu](English.md#your-wordpress-menu)\n- [Upload shortcuts](English.md#upload-shortcuts)\n- [FAQ by topic](FAQ-English.md)\n- [Changelog](Changelog-English.md)\n\n**Deutsch**\n\n- [Anleitung](Deutsch.md)\n- [Dein Toolbar-Menü](Deutsch.md#dein-wordpress-menü)\n- [Upload-Verknüpfungen](Deutsch.md#upload-verknüpfungen)\n- [Fragen nach Themen](FAQ-Deutsch.md)\n- [Änderungsverlauf](Changelog-Deutsch.md)\n')
(root/'changelog-archive.md').write_text('# Release history / Veröffentlichungshistorie\n\n[English](docs/CHANGELOG.md) · [Deutsch](docs/CHANGELOG-de.md)\n\nFor single WordPress sites and Multisite networks, supported since 2012.\nFür einzelne WordPress-Websites und Multisite-Netzwerke, unterstützt seit 2012.\n\nThe complete relevant history is maintained in these documents.\nDie vollständige relevante Historie wird in diesen Dokumenten gepflegt.\n')
print('Generated bilingual readmes, '+str(len(data['faq']))+' topic questions and '+str(len(data['releases']))+' historical version records.')

# Keep generated documents free of trailing blank lines.
for path in [root/"README.md",root/"README-de.md",root/"readme.txt",root/"readme-de.txt",*(root/"docs/wiki").glob("*.md")]:
 path.write_text(path.read_text().rstrip()+"\n")
