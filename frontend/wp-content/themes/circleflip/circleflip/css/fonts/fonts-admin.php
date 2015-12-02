<?php
/**
 * @package Circle Flip
 * @author Creiden
 * @link http://creiden.com
 */

header("Content-type: text/css;");

$url = $_SERVER["SCRIPT_FILENAME"];
$strpos = strpos($url, 'wp-content');
$base = substr($url, 0, $strpos);

require_once $base . 'wp-load.php';
$googleFonts = implode('|',cr_get_option('cust_font'));
			if ($googleFonts != '')
				$link = 'http://fonts.googleapis.com/css?family=' . preg_replace("/ /", "+", $googleFonts);
?>
@import url('<?php echo $link?>');
@import url(http://fonts.googleapis.com/css?family=Raleway:400);
@font-face {
    font-family: 'sourceSans';
    src: url('SourceSans/sourcesanspro-regular-webfont.eot');
    src: url('SourceSans/sourcesanspro-regular-webfont.eot?#iefix') format('embedded-opentype'),
         url('SourceSans/sourcesanspro-regular-webfont.woff') format('woff'),
         url('SourceSans/sourcesanspro-regular-webfont.ttf') format('truetype'),
         url('SourceSans/sourcesanspro-regular-webfont.svg#sourceSans') format('svg');
    font-weight: normal;
    font-style: normal;
}
@font-face {
    font-family: 'SourceSansSemiBold';
    src: url('SourceSansSemiBold/SourceSansPro_Semibold.eot');
    src: url('SourceSansSemiBold/SourceSansPro_Semibold.eot?#iefix') format('embedded-opentype'),
         url('SourceSansSemiBold/SourceSansPro_Semibold.woff') format('woff'),
         url('SourceSansSemiBold/SourceSansPro_Semibold.ttf') format('truetype'),
         url('SourceSansSemiBold/SourceSansPro_Semibold.svg#SourceSansSemiBold') format('svg');
    font-weight: normal;
    font-style: normal;
}
@font-face {
    font-family: 'sourceSansLight';
    src: url('SourceSansLight/SourceSansPro-Light.eot');
    src: url('SourceSansLight/SourceSansPro-Light.eot?#iefix') format('embedded-opentype'),
         url('SourceSansLight/SourceSansPro-Light.woff') format('woff'),
         url('SourceSansLight/SourceSansPro-Light.ttf') format('truetype'),
         url('SourceSansLight/SourceSansPro-Light.svg#sourceSansLight') format('svg');
    font-weight: normal;
    font-style: normal;
}
@font-face {
	font-family: 'OpenSansRegular';
	src: url('OpenSansRegular/OpenSans-Regular-webfont.eot');
	src: url('OpenSansRegular/OpenSans-Regular-webfont.eot?#iefix') format('embedded-opentype'), url('OpenSansRegular/OpenSans-Regular-webfont.woff') format('woff'), url('OpenSansRegular/OpenSans-Regular-webfont.ttf') format('truetype'), url('OpenSansRegular/OpenSans-Regular-webfont.svg#OpenSansRegular') format('svg');
	font-weight: normal;
	font-style: normal;
}
@font-face {
	font-family: 'OpenSansLight';
	src: url('OpenSansLight/OpenSans-Light-webfont.eot');
	src: url('OpenSansLight/OpenSans-Light-webfont.eot?#iefix') format('embedded-opentype'), url('OpenSansLight/OpenSans-Light-webfont.woff') format('woff'), url('OpenSansLight/OpenSans-Light-webfont.ttf') format('truetype'), url('OpenSansLight/OpenSans-Light-webfont.svg#OpenSansLight') format('svg');
	font-weight: normal;
	font-style: normal;
}
@font-face {
	font-family: 'OpenSansBold';
	src: url('OpenSansBold/OpenSans-Bold-webfont.eot');
	src: url('OpenSansBold/OpenSans-Bold-webfont.eot?#iefix') format('embedded-opentype'), url('OpenSansBold/OpenSans-Bold-webfont.woff') format('woff'), url('OpenSansBold/OpenSans-Bold-webfont.ttf') format('truetype'), url('OpenSansBold/OpenSans-Bold-webfont.svg#OpenSansBold') format('svg');
	font-weight: normal;
	font-style: normal;
}
@font-face {
	font-family: 'OpenSansSemibold';
	src: url('OpenSansSemibold/OpenSans-Semibold-webfont.eot');
	src: url('OpenSansSemibold/OpenSans-Semibold-webfont.eot?#iefix') format('embedded-opentype'), url('OpenSansSemibold/OpenSans-Semibold-webfont.woff') format('woff'), url('OpenSansSemibold/OpenSans-Semibold-webfont.ttf') format('truetype'), url('OpenSansSemibold/OpenSans-Semibold-webfont.svg#OpenSansSemibold') format('svg');
	font-weight: normal;
	font-style: normal;
}
@font-face {
	font-family: 'OpenSansItalic';
	src: url('OpenSansItalic/OpenSans-Italic-webfont.eot');
	src: url('OpenSansItalic/OpenSans-Italic-webfont.eot?#iefix') format('embedded-opentype'), url('OpenSansItalic/OpenSans-Italic-webfont.woff') format('woff'), url('OpenSansItalic/OpenSans-Italic-webfont.ttf') format('truetype'), url('OpenSansItalic/OpenSans-Italic-webfont.svg#OpenSansItalic') format('svg');
	font-weight: normal;
	font-style: normal;
}
@font-face {
	font-family: 'droidSansRegular';
	src: url('droidsans_regular/DroidSans-webfont.eot');
	src: url('droidsans_regular/DroidSans-webfont.eot?#iefix') format('embedded-opentype'), url('droidsans_regular/DroidSans-webfont.woff') format('woff'), url('droidsans_regular/DroidSans-webfont.ttf') format('truetype'), url('droidsans_regular/DroidSans-webfont.svg#OpenSansRegular') format('svg');
	font-weight: normal;
	font-style: normal;
}
@font-face {
    font-family: 'bebasNeue';
    src: url('bebasNeue/BebasNeue-webfont.eot');
    src: url('bebasNeue/BebasNeue-webfont.eot?#iefix') format('embedded-opentype'),
         url('bebasNeue/BebasNeue-webfont.woff') format('woff'),
         url('bebasNeue/BebasNeue-webfont.ttf') format('truetype'),
         url('bebasNeue/BebasNeue-webfont.svg#bebasNeue') format('svg');
    font-weight: normal;
    font-style: normal;
}
@font-face {
  font-family: 'fontello';
  src: url('fontello/fontello.eot?54856606');
  src: url('fontello/fontello.eot?54856606#iefix') format('embedded-opentype'),
       url('fontello/fontello.woff?54856606') format('woff'),
       url('fontello/fontello.ttf?54856606') format('truetype'),
       url('fontello/fontello.svg?54856606#fontello') format('svg');
  font-weight: normal;
  font-style: normal;
}

@font-face {
	font-family: 'museo_slab500';
	src: url('museoslab500/Museo_Slab_500_2-webfont.eot');
	src: url('museoslab500/Museo_Slab_500_2-webfont.eot?#iefix') format('embedded-opentype'), url('museoslab500/Museo_Slab_500_2-webfont.woff') format('woff'), url('museoslab500/Museo_Slab_500_2-webfont.ttf') format('truetype'), url('museoslab500/Museo_Slab_500_2-webfont.svg#museo_slab500') format('svg');
	font-weight: normal;
	font-style: normal;
}
@font-face {
	font-family: 'inikaNormal';
	src: url('inikaNormal/inikaNormal.eot');
	src: local('☺'), url('inikaNormal/inikaNormal.woff') format('woff'), url('inikaNormal/inikaNormal.ttf') format('truetype'), url('inikaNormal/inikaNormal.svg') format('svg');
	font-weight: normal;
	font-style: normal;
}
@font-face {
	font-family: 'DroidArabicKufi';
	font-style: normal;
	font-weight: 400;
	src: url('DroidKufi/DroidKufi-Regular.ttf') format('truetype');
}
@font-face {
	font-family: 'DroidArabicKufiBold';
	font-style: normal;
	font-weight: 400;
	src: url('DroidKufi/DroidKufi-Bold.ttf') format('truetype');
}

[class^="icon-"]:before, [class*=" icon-"]:before {
  font-family: "fontello";
  font-style: normal;
  font-weight: normal;
  speak: none;
  display: inline-block;
  text-decoration: inherit;
  width: 1em;
  text-align: center;
  font-variant: normal;
  text-transform: none;
  line-height: 1em;
}
.icon-spin3:before{content:'\e927';}
.icon-search:before{content:'\e920';}
.icon-plus:before{content:'\e924';}
.icon-comment:before{content:'\e922';}
.icon-chat:before{content:'\e921';}
.icon-doc-text:before{content:'\e91c';}
.icon-menu:before{content:'\e91f';}
.icon-note:before{content:'\e800';}
.icon-note-beamed:before{content:'\e801';}
.icon-music:before{content:'\e802';}
.icon-search-1:before{content:'\e803';}
.icon-flashlight:before{content:'\e804';}
.icon-mail:before{content:'\e805';}
.icon-heart:before{content:'\e806';}
.icon-heart-empty:before{content:'\e807';}
.icon-star:before{content:'\e808';}
.icon-star-empty:before{content:'\e809';}
.icon-user:before{content:'\e80a';}
.icon-users:before{content:'\e80b';}
.icon-user-add:before{content:'\e80c';}
.icon-video:before{content:'\e80d';}
.icon-picture:before{content:'\e80e';}
.icon-camera:before{content:'\e80f';}
.icon-layout:before{content:'\e810';}
.icon-menu-1:before{content:'\e811';}
.icon-check:before{content:'\e812';}
.icon-cancel:before{content:'\e813';}
.icon-cancel-circled:before{content:'\e814';}
.icon-cancel-squared:before{content:'\e815';}
.icon-plus-1:before{content:'\e816';}
.icon-plus-circled:before{content:'\e817';}
.icon-plus-squared:before{content:'\e818';}
.icon-minus:before{content:'\e819';}
.icon-minus-circled:before{content:'\e81a';}
.icon-minus-squared:before{content:'\e81b';}
.icon-help:before{content:'\e81c';}
.icon-help-circled:before{content:'\e81d';}
.icon-info:before{content:'\e81e';}
.icon-info-circled:before{content:'\e81f';}
.icon-back:before{content:'\e820';}
.icon-home:before{content:'\e821';}
.icon-link:before{content:'\e822';}
.icon-attach:before{content:'\e823';}
.icon-lock:before{content:'\e824';}
.icon-lock-open:before{content:'\e825';}
.icon-eye:before{content:'\e826';}
.icon-tag:before{content:'\e827';}
.icon-bookmark:before{content:'\e828';}
.icon-bookmarks:before{content:'\e829';}
.icon-flag:before{content:'\e82a';}
.icon-thumbs-up:before{content:'\e82b';}
.icon-thumbs-down:before{content:'\e82c';}
.icon-download:before{content:'\e82d';}
.icon-upload:before{content:'\e82e';}
.icon-upload-cloud:before{content:'\e82f';}
.icon-reply:before{content:'\e830';}
.icon-reply-all:before{content:'\e831';}
.icon-forward-1:before{content:'\e832';}
.icon-quote:before{content:'\e833';}
.icon-code:before{content:'\e834';}
.icon-export:before{content:'\e835';}
.icon-pencil:before{content:'\e836';}
.icon-feather:before{content:'\e837';}
.icon-print:before{content:'\e838';}
.icon-retweet:before{content:'\e839';}
.icon-keyboard:before{content:'\e83a';}
.icon-comment-1:before{content:'\e83b';}
.icon-chat-1:before{content:'\e83c';}
.icon-bell:before{content:'\e83d';}
.icon-attention:before{content:'\e83e';}
.icon-alert:before{content:'\e83f';}
.icon-vcard:before{content:'\e840';}
.icon-address:before{content:'\e841';}
.icon-location:before{content:'\e842';}
.icon-map:before{content:'\e843';}
.icon-direction:before{content:'\e844';}
.icon-compass:before{content:'\e845';}
.icon-cup:before{content:'\e846';}
.icon-trash:before{content:'\e847';}
.icon-doc:before{content:'\e848';}
.icon-docs:before{content:'\e849';}
.icon-doc-landscape:before{content:'\e84a';}
.icon-doc-text-1:before{content:'\e84b';}
.icon-doc-text-inv:before{content:'\e84c';}
.icon-newspaper:before{content:'\e84d';}
.icon-book-open:before{content:'\e84e';}
.icon-book:before{content:'\e84f';}
.icon-folder:before{content:'\e850';}
.icon-archive:before{content:'\e851';}
.icon-box:before{content:'\e852';}
.icon-rss:before{content:'\e853';}
.icon-phone:before{content:'\e854';}
.icon-cog:before{content:'\e855';}
.icon-tools:before{content:'\e856';}
.icon-share:before{content:'\e857';}
.icon-shareable:before{content:'\e858';}
.icon-basket-1:before{content:'\e859';}
.icon-bag:before{content:'\e85a';}
.icon-calendar:before{content:'\e85b';}
.icon-login:before{content:'\e85c';}
.icon-logout:before{content:'\e85d';}
.icon-mic:before{content:'\e85e';}
.icon-mute:before{content:'\e85f';}
.icon-sound:before{content:'\e860';}
.icon-volume:before{content:'\e861';}
.icon-clock:before{content:'\e862';}
.icon-hourglass:before{content:'\e863';}
.icon-lamp:before{content:'\e864';}
.icon-light-down:before{content:'\e865';}
.icon-light-up:before{content:'\e866';}
.icon-adjust:before{content:'\e867';}
.icon-block:before{content:'\e868';}
.icon-resize-full:before{content:'\e869';}
.icon-resize-small:before{content:'\e86a';}
.icon-popup:before{content:'\e86b';}
.icon-publish:before{content:'\e86c';}
.icon-window:before{content:'\e86d';}
.icon-arrow-combo:before{content:'\e86e';}
.icon-down-circled:before{content:'\e86f';}
.icon-left-circled:before{content:'\e870';}
.icon-right-circled:before{content:'\e871';}
.icon-up-circled:before{content:'\e872';}
.icon-down-open:before{content:'\e873';}
.icon-left-open:before{content:'\e874';}
.icon-right-open:before{content:'\e875';}
.icon-up-open:before{content:'\e876';}
.icon-down-open-mini:before{content:'\e877';}
.icon-left-open-mini:before{content:'\e878';}
.icon-right-open-mini:before{content:'\e879';}
.icon-up-open-mini:before{content:'\e87a';}
.icon-down-open-big:before{content:'\e87b';}
.icon-left-open-big:before{content:'\e87c';}
.icon-right-open-big:before{content:'\e87d';}
.icon-up-open-big:before{content:'\e87e';}
.icon-down:before{content:'\e87f';}
.icon-left:before{content:'\e880';}
.icon-right:before{content:'\e881';}
.icon-up:before{content:'\e882';}
.icon-down-dir:before{content:'\e883';}
.icon-left-dir:before{content:'\e884';}
.icon-right-dir:before{content:'\e885';}
.icon-up-dir:before{content:'\e886';}
.icon-down-bold:before{content:'\e887';}
.icon-left-bold:before{content:'\e888';}
.icon-right-bold:before{content:'\e889';}
.icon-up-bold:before{content:'\e88a';}
.icon-down-thin:before{content:'\e88b';}
.icon-left-thin:before{content:'\e88c';}
.icon-heart-8:before{content:'\e923';}
.icon-up-thin:before{content:'\e88e';}
.icon-ccw:before{content:'\e88f';}
.icon-cw:before{content:'\e890';}
.icon-arrows-ccw:before{content:'\e891';}
.icon-level-down:before{content:'\e892';}
.icon-level-up:before{content:'\e893';}
.icon-shuffle:before{content:'\e894';}
.icon-loop:before{content:'\e895';}
.icon-switch:before{content:'\e896';}
.icon-play:before{content:'\e897';}
.icon-stop:before{content:'\e898';}
.icon-pause:before{content:'\e899';}
.icon-record:before{content:'\e89a';}
.icon-to-end:before{content:'\e89b';}
.icon-to-start:before{content:'\e89c';}
.icon-fast-forward:before{content:'\e89d';}
.icon-fast-backward:before{content:'\e89e';}
.icon-progress-0:before{content:'\e89f';}
.icon-progress-1:before{content:'\e8a0';}
.icon-progress-2:before{content:'\e8a1';}
.icon-progress-3:before{content:'\e8a2';}
.icon-target:before{content:'\e8a3';}
.icon-palette:before{content:'\e8a4';}
.icon-list:before{content:'\e8a5';}
.icon-list-add:before{content:'\e8a6';}
.icon-signal:before{content:'\e8a7';}
.icon-trophy:before{content:'\e8a8';}
.icon-battery:before{content:'\e8a9';}
.icon-back-in-time:before{content:'\e8aa';}
.icon-monitor:before{content:'\e8ab';}
.icon-mobile:before{content:'\e8ac';}
.icon-network:before{content:'\e8ad';}
.icon-cd:before{content:'\e8ae';}
.icon-inbox:before{content:'\e8af';}
.icon-install:before{content:'\e8b0';}
.icon-globe:before{content:'\e8b1';}
.icon-cloud:before{content:'\e8b2';}
.icon-cloud-thunder:before{content:'\e8b3';}
.icon-flash:before{content:'\e8b4';}
.icon-moon:before{content:'\e8b5';}
.icon-flight:before{content:'\e8b6';}
.icon-paper-plane:before{content:'\e8b7';}
.icon-leaf:before{content:'\e8b8';}
.icon-lifebuoy:before{content:'\e8b9';}
.icon-mouse:before{content:'\e8ba';}
.icon-briefcase:before{content:'\e8bb';}
.icon-suitcase:before{content:'\e8bc';}
.icon-dot:before{content:'\e8bd';}
.icon-dot-2:before{content:'\e8be';}
.icon-dot-3:before{content:'\e8bf';}
.icon-brush:before{content:'\e8c0';}
.icon-magnet:before{content:'\e8c1';}
.icon-infinity:before{content:'\e8c2';}
.icon-erase:before{content:'\e8c3';}
.icon-chart-pie:before{content:'\e8c4';}
.icon-chart-line:before{content:'\e8c5';}
.icon-chart-bar:before{content:'\e8c6';}
.icon-chart-area:before{content:'\e8c7';}
.icon-tape:before{content:'\e8c8';}
.icon-graduation-cap:before{content:'\e8c9';}
.icon-language:before{content:'\e8ca';}
.icon-ticket:before{content:'\e8cb';}
.icon-water:before{content:'\e8cc';}
.icon-droplet:before{content:'\e8cd';}
.icon-air:before{content:'\e8ce';}
.icon-credit-card:before{content:'\e8cf';}
.icon-floppy:before{content:'\e8d0';}
.icon-clipboard:before{content:'\e8d1';}
.icon-megaphone:before{content:'\e8d2';}
.icon-database:before{content:'\e8d3';}
.icon-drive:before{content:'\e8d4';}
.icon-bucket:before{content:'\e8d5';}
.icon-thermometer:before{content:'\e8d6';}
.icon-key:before{content:'\e8d7';}
.icon-flow-cascade:before{content:'\e8d8';}
.icon-flow-branch:before{content:'\e8d9';}
.icon-flow-tree:before{content:'\e8da';}
.icon-flow-line:before{content:'\e8db';}
.icon-flow-parallel:before{content:'\e8dc';}
.icon-rocket:before{content:'\e8dd';}
.icon-gauge:before{content:'\e8de';}
.icon-traffic-cone:before{content:'\e8df';}
.icon-cc:before{content:'\e8e0';}
.icon-cc-by:before{content:'\e8e1';}
.icon-cc-nc:before{content:'\e8e2';}
.icon-cc-nc-eu:before{content:'\e8e3';}
.icon-cc-nc-jp:before{content:'\e8e4';}
.icon-cc-sa:before{content:'\e8e5';}
.icon-cc-nd:before{content:'\e8e6';}
.icon-cc-pd:before{content:'\e8e7';}
.icon-cc-zero:before{content:'\e8e8';}
.icon-cc-share:before{content:'\e8e9';}
.icon-cc-remix:before{content:'\e8ea';}
.icon-github:before{content:'\e8eb';}
.icon-github-circled:before{content:'\e8ec';}
.icon-flickr:before{content:'\e8ed';}
.icon-flickr-circled:before{content:'\e8ee';}
.icon-vimeo:before{content:'\e8ef';}
.icon-vimeo-circled:before{content:'\e8f0';}
.icon-twitter:before{content:'\e8f1';}
.icon-twitter-circled:before{content:'\e8f2';}
.icon-facebook:before{content:'\e8f3';}
.icon-facebook-circled:before{content:'\e8f4';}
.icon-facebook-squared:before{content:'\e8f5';}
.icon-gplus:before{content:'\e8f6';}
.icon-gplus-circled:before{content:'\e8f7';}
.icon-pinterest:before{content:'\e8f8';}
.icon-pinterest-circled:before{content:'\e8f9';}
.icon-tumblr:before{content:'\e8fa';}
.icon-tumblr-circled:before{content:'\e8fb';}
.icon-linkedin:before{content:'\e8fc';}
.icon-linkedin-circled:before{content:'\e8fd';}
.icon-dribbble:before{content:'\e8fe';}
.icon-dribbble-circled:before{content:'\e8ff';}
.icon-stumbleupon:before{content:'\e900';}
.icon-stumbleupon-circled:before{content:'\e901';}
.icon-lastfm:before{content:'\e902';}
.icon-lastfm-circled:before{content:'\e903';}
.icon-rdio:before{content:'\e904';}
.icon-rdio-circled:before{content:'\e905';}
.icon-spotify:before{content:'\e906';}
.icon-spotify-circled:before{content:'\e907';}
.icon-qq:before{content:'\e908';}
.icon-instagram:before{content:'\e909';}
.icon-dropbox:before{content:'\e90a';}
.icon-evernote:before{content:'\e90b';}
.icon-flattr:before{content:'\e90c';}
.icon-skype:before{content:'\e90d';}
.icon-skype-circled:before{content:'\e90e';}
.icon-renren:before{content:'\e90f';}
.icon-sina-weibo:before{content:'\e910';}
.icon-paypal:before{content:'\e911';}
.icon-picasa:before{content:'\e912';}
.icon-soundcloud:before{content:'\e913';}
.icon-mixi:before{content:'\e914';}
.icon-behance:before{content:'\e915';}
.icon-google-circles:before{content:'\e916';}
.icon-vkontakte:before{content:'\e917';}
.icon-smashing:before{content:'\e918';}
.icon-sweden:before{content:'\e919';}
.icon-db-shape:before{content:'\e91a';}
.icon-logo-db:before{content:'\e91b';}
.icon-ok:before{content:'\e925';}
.icon-plus-4:before{content:'\e91d';}
.icon-menu-3:before{content:'\e91e';}
.icon-folder-open-1:before{content:'\e926';}
.icon-right-thin:before{content:'\e88d';}
.icon-youtube:before { content: '\e928'; }
.mceText{font-size: 12px !important;}