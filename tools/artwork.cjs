/** Derive every banner from its outlined 2:1 vector master. Requires sharp. */
const fs=require('fs'),path=require('path'),sharp=require('sharp');
const root=path.resolve(__dirname,'..'),brand=path.join(root,'assets/brand'),github=path.join(root,'assets-github'),source=path.join(root,'assets-source');
(async()=>{
for(const lang of ['en','de']){
 const master=fs.readFileSync(path.join(source,`banner-master-${lang}-2560x1280.svg`),'utf8');
 if(/<text\b|<image\b|font-family|<script\b/.test(master))throw Error('Master must be outlined native vectors');
 const resizeSvg=(width,height,viewBox)=>master.replace(/width="2560"/,'width="'+width+'"').replace(/height="1280"/,'height="'+height+'"').replace('viewBox="0 0 1280 640"','viewBox="'+viewBox+'"');
 await sharp(Buffer.from(master)).png().toFile(path.join(source,`banner-master-${lang}-2560x1280.png`));
 const gh=resizeSvg(1280,640,'0 0 1280 640');fs.writeFileSync(path.join(github,`banner-${lang}-1280x640.svg`),gh);
 await sharp(Buffer.from(gh)).png().toFile(path.join(github,`banner-${lang}-1280x640.png`));
 const h=500*1280/1544,top=(640-h)/2,wp=resizeSvg(1544,500,`0 ${top.toFixed(12)} 1280 ${h.toFixed(12)}`);
 fs.writeFileSync(path.join(brand,`banner-${lang}.svg`),wp);
 for(const [width,height] of [[1544,500],[772,250]])await sharp(Buffer.from(wp)).resize(width,height).png().toFile(path.join(brand,`banner-${lang}-${width}x${height}.png`));
 fs.writeFileSync(path.join(brand,`social-card-${lang}.svg`),gh);await sharp(Buffer.from(gh)).png().toFile(path.join(brand,`social-card-${lang}-1280x640.png`));
 if(lang==='en'){fs.writeFileSync(path.join(brand,'social-card.svg'),gh);await sharp(Buffer.from(gh)).png().toFile(path.join(brand,'social-card-1280x640.png'));}
}
const icon=fs.readFileSync(path.join(brand,'icon.svg'));
for(const size of [32,64,128,256,512,1024])await sharp(icon,{density:size*72/256}).resize(size,size).png().toFile(path.join(brand,`icon-${size}x${size}.png`));
console.log('Both masters rendered; all DE/EN banners derived by uniform scaling and centered crop.');
})().catch(e=>{console.error(e);process.exit(1)});
