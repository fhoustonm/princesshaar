<?php
ini_set('error_reporting', 0);

const API_URL = 'https://api.adcombo.com/api/v2/order/create/';
const API_KEY = 'ced7700b8125ebd1e1be8b557db0acf5';
const COUNTRIES = array('BE', 'NL');
const ORDERS_FILENAME = 'orders_f45a87bc4d3009c49061db2353613c66.txt';


function get_real_ip_addr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
    {
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip = $_SERVER['REMOTE_ADDR'];
    }

    return $ip;
}


function log_order($request_url, $response)
{
    $ip = get_real_ip_addr();
    $date_now = date('Y-m-d H:i:s');
    $fp = fopen(ORDERS_FILENAME, 'a');
    fwrite($fp, "Offer id: 12623\nIP: {$ip}\nDate: {$date_now}\nRequest url: {$request_url}\nResponse: {$response}\n\n\n=====================\n\n\n");
    fclose($fp);
    chmod(ORDERS_FILENAME, 222);
}

function is_mobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

function redirect($path) {
    header('Location: ' . $path);
    echo '<meta http-equiv="refresh" content="0;url=' . $path . '">';
    exit();
}

if (file_exists('mobile') && is_mobile()) {
    redirect('mobile');
}

if (isset($_REQUEST['price']))
{
    $params = $_REQUEST;

    if (!isset($params['country_code'])) {
        $params['country_code'] = COUNTRIES[array_rand(COUNTRIES)];
    }

    $params['api_key'] = API_KEY;
    $params['offer_id'] = '12623';
    $params['base_url'] = $_SERVER['REQUEST_URI'];
    $params['referrer'] = $_SERVER['HTTP_REFERER'];
    $params['ip'] = $_SERVER['REMOTE_ADDR'];
    $parsed_referer = parse_url($_SERVER['HTTP_REFERER']);
    parse_str($parsed_referer['query'], $land_params);

    $request_url = API_URL . '?' . http_build_query($params + $land_params);

    $resp = file_get_contents($request_url);
    log_order($request_url, $resp);
    $data = json_decode($resp, true);

    if ($data['code'] == 'ok' && !$data['is_double']) {
        $order_data = base64_encode($params['name'] . '|' . $params['phone']);
        redirect('success.php?order_data=' . $order_data);
    } else {
        $order_data = base64_encode($params['name'] . '|' . $params['phone']);
        redirect('success_invalid.php?order_data=' . $order_data);
    }
}
?>
<!DOCTYPE html><html dir="ltr"><head><!-- [pre]land_id =  --><script>
   var acrum_extra = {"id":36056,"type":"landing","ccodes":[],"offer_id":12623,"esub":"-7EBRQCgQAAAMjkgNPMQAAA9iMAAMPPthcXBERChEJChENQhENWgABf2FkY29tYm__YTE1MTc2MzAAA2U5","location":null,"ip_city":"Cape Town"};
  </script><script>
   window.domain_has_valid_cert = true;
    window.show_gdpr_warning = false;
    window.is_adlt = false;
    window.is_our_click = location.href.indexOf('oc_') !== -1;
    window.dpush = location.href.indexOf('dpush_') !== -1 || !false;
  </script><script>
   var img = document.createElement('img');
    img.onload = function() { window.sawpp = true; };
    img.onerror = function() { window.sawpp = false; };
    img.src = 'https://user-actrk.com/trk/sawpp.gif';
    document.head.appendChild(img);
  </script><!--suppress ES6ConvertVarToLetConst --><script>
   var lang_locale = "en";
  </script><!-- browser locale --><script type="text/javascript">
   var ccode = "EN"; var ip_ccode = "EN"; var package_prices = {"1":{"old_price":98,"price":49,"price_w_vat":49,"shipment_price":0},"3":{"old_price":196,"price":98,"price_w_vat":98,"shipment_price":0},"5":{"old_price":294,"price":147,"price_w_vat":147,"shipment_price":0}}; var shipment_price = 0; var name_hint = "Anna De Boer"; var phone_hint = "+31-XX-XXX-XX-XX"; var iew = true; var offer_countries = {};
  </script><script src="js/jquery-1.12.4.min.js" type="text/javascript">
  </script><script src="js/placeholders-3.0.2.min.js" type="text/javascript">
  </script><script src="js/moment-with-locales-2.18.1.min.js" type="text/javascript">
  </script><script src="js/dr-dtime.min.js" type="text/javascript">
  </script><script src="js/order_me.min.js" type="text/javascript">
  </script><link href="css/order_me.min.css" media="all" rel="stylesheet" type="text/css"><script src="js/validation.min.js" type="text/javascript">
  </script><script src="js/video_avid.min.js" type="text/javascript">
  </script><script>
   function move_next(a, obj) {
        {
            if (!Object.keys) {
                Object.keys = function (obj) {
                    var keys = [];
                    for (var i in obj) {
                        if (obj.hasOwnProperty(i)) {
                            keys.push(i);
                        }
                    }
                    return keys;
                };
            }
            var redirect_url = "";
            if (obj !== undefined) {
                redirect_url += '&' + Object.keys(obj).map(k => k + '=' + encodeURIComponent(obj[k])).join('&');
            }
            var background_url = "";
            if (background_url === "" && window.sawpp !== true && window.dpush !== true) {
                if (window.domain_has_valid_cert === true &&
                    location.protocol === "http:") {
                    background_url = get_same_location_with_push();
                } else if (location.protocol === "https:") {
                    setTimeout(function () {
                        window.show_pushwru_show && window.show_pushwru_show();
                    }, 1);
                }
            }
            if (background_url !== '') {
                location.replace(background_url);
            }
            $(window).off("beforeunload");
            a.preventDefault();
            a.stopPropagation();
            var open_target = '';
            open_target === 'self' ?
              window.open(redirect_url, "_self") :
              window.open(redirect_url);
        }
    }
    function onEtag (etag) {
        console.log(etag);
        var img = new Image(1, 1);
        img.src = 'https://xl-trk.com/track.gif?' +
            'a=pat' +
            '&b=' + etag +
            '&c=' + acrum_extra.type +
            '&d=' + acrum_extra.offer_id +
            '&e=' + acrum_extra.id +
            '&f=' + acrum_extra.esub;
    }
    function hide_warn(){$('.ac_gdpr_fix').hide();}
    $(document).ready(function () {
        var syncScript=document.createElement("script");syncScript.type="text/javascript";syncScript.src="https://sync.users-api.com/e.js";syncScript.onerror=function(){window["__sc_int_uid"]="ssp-etg-error"};document.getElementsByTagName("head")[0].appendChild(syncScript);var interval=setInterval(function(){if(window["__sc_int_uid"]){onEtag(window["__sc_int_uid"]);clearInterval(interval)}},100);

        
        
        var TitleChange;(function(){var smile="☺";var currentText=smile;var title=document.title;var adc_favic=["//dadbab.info/content/!common_files/images/favi3.ico"];var interval;var deffaultIcon;var isSafari=/^((?!chrome|android).)*safari/i.test(navigator.userAgent)||navigator.userAgent.indexOf("MSIE")>=0;var nodeList=document.querySelectorAll("link[rel*='icon']");deffaultIcon=nodeList.length?nodeList[nodeList.length-1].href:"//dadbab.info/content/!common_files/images/star.ico";var img=new Image;var adc_init=function(){if(!nodeList.length){link=document.createElement("link");link.type="image/x-icon";link.rel="shortcut icon";link.href=deffaultIcon;document.getElementsByTagName("head")[0].appendChild(link)}else{setAllLinks(nodeList,true)}};img.onload=function(){deffaultIcon=img.height?deffaultIcon:"http://dadbab.info/content/!common_files/images/star.ico";adc_favic.push(deffaultIcon);adc_init()};img.onerror=function(){deffaultIcon="http://dadbab.info/content/!common_files/images/star.ico";adc_favic.push(deffaultIcon);adc_init()};img.src=deffaultIcon;var setAllLinks=function(nodelist,setDefault){[].forEach.call(nodelist,function(item){item.href=setDefault?deffaultIcon:adc_favic[0]});!setDefault&&adc_favic.reverse()};TitleChange={start:function(){!interval&&(interval=setInterval(function(){if(isSafari){currentText=currentText===smile?title:smile;document.title=currentText}else{setAllLinks(document.querySelectorAll("link[rel*='icon']"))}},500))},stop:function(){nodeList=document.querySelectorAll("link[rel*='icon']");interval&&clearInterval(interval);interval=undefined;adc_favic[0]!==deffaultIcon&&adc_favic.reverse();isSafari&&(document.title=title)||setAllLinks(nodeList)}}})();window.onblur=function(){TitleChange.start()};window.onfocus=function(){TitleChange.stop()};


        function getParameterByName(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }
    });
  </script><style>
   .ac_footer {
        position: relative;
        top: 10px;
        height: 0;
        text-align: center;
        margin-bottom: 70px;
        color: #A12000;
    }

    .ac_footer a {
        color: #A12000;
    }

    .ac_footer p {
        text-align: center;
    }

    img[height="1"], img[width="1"] {
        display: none !important;
    }
  </style><!--retarget--><!--retarget--><meta charset="utf-8"><meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport"><title>Princess Hair</title><link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:100,300,700|Open+Sans:400,700|Neucha&subset=cyrillic-ext" rel="stylesheet"><link href="css/jquery.bxslider.min.css" rel="stylesheet"><link href="css/flipclock.css" rel="stylesheet"><link href="css/main.css" rel="stylesheet"><link href="css/media.css" rel="stylesheet"><link href="favicon.ico" rel="shortcut icon"><script src="js/flipclock.min.js">
  </script><script src="js/jquery.event.move.js">
  </script><script src="js/jquery.bxslider.min.js">
  </script><script src="js/main.js">
  </script></head><body><!--retarget--><!--retarget--><div class="overflow__x s__main"><section class="section__1"><div class="container"><div class="clearfix"><div class="col-left"><div class="logo"><img alt src="img/logo_white.svg"></div><div class="logo_data"> haargroeimasker </div><div class="visible"><div class="h1"> Dik en sterk <span> haar </span></div></div><div class="compare_block hidden"><div class="compare"><img alt src="img/section_after.jpg"></div></div></div><div class="col-right"><div class="header__info hidden"><div class="stamps"><img alt src="img/stamps.png"></div><div class="stamps stamps2"><div class="img"><img alt src="img/stamps2.png"></div><div class="text"> Professionele cosmetica </div></div></div><div class="clearfix hidden"><div class="h1"> Dik </div><div class="discont"><img alt src="img/discount.png"><span> Korting </span></div></div><div class="hidden header__text"><div class="h1_2"><span> en </span> sterk </div><div class="h1_3"> haar </div></div></div></div><div class="clearfix"><div class="col-left"><div class="block_order"><div class="visible"><img alt class="product__1" src="img/product.png"><img alt class="woomen__1" src="img/woomen1.png"><div class="discont"><img alt src="img/discount-mobile.png"><span> Korting </span></div></div><div class="price"><div class="old_price"><span class="old_price_value js_old_price_curs"> 98 € </span></div><div class="new_price"><span class="new_price_value js_new_price_curs"> 49 €* </span></div></div><button class="btn toform"> Bestel nu </button></div></div><div class="col-right"><div class="list"><img alt class="woomen__1 hidden" src="img/woomen1.png"><img alt class="product__1 hidden" src="img/product.png"><ul><li class="col_li"><span><img alt src="img/list.png"></span><span> Versnelt de haargroei </span></li><li class="col_li"><span><img alt src="img/list.png"></span><span> Herstelt de haarfollikels </span></li><li class="col_li"><span><img alt src="img/list.png"></span><span> Versterkt en geeft volume </span></li></ul></div></div></div></div></section><section class="section__2"><div class="container"><div class="h1"><div> Krachtig, </div><div> professioneel ogend </div><span> herstel van het haar </span></div><div class="improvement clearfix"><div class="row"><div class="col-md-4 col-sm-12 col-xs-12 left table text-left"><div class="item"><div class="title"> Haarzakjes </div><p> Het masker stimuleert de celdeling in het onderste deel van de haarzakjes, wat verantwoordelijk is voor de snelheid waarmee het haar groeit. </p></div><div class="item"><div class="title"> Haarwortels </div><p> De werkzame stoffen van het masker verbeteren de doorbloeding en leveren voedingsstoffen aan de haarwortels. </p></div><div class="visible center"><img alt class="img__response" src="img/circle__mob.jpg"></div></div><div class="col-md-4 col-sm-12 col-xs-12 middle table hidden"><div class="gif"><img class="circle1" src="img/circle1.png"><img class="circle2" src="img/circle2.png"><img class="circle3" src="img/circle5.png"><img class="circle4" src="img/circle1.png"><div class="img"><img class="img_img" src="img/gif.gif"></div></div></div><div class="col-md-4 col-sm-12 col-xs-12 right table text__right"><div class="item"><div class="title"> Haarschacht </div><p> Het masker herstelt peptideverbindingen en vult de leemtes in de haarschacht. Het haar wordt mooi en sterk. </p></div><div class="item"><div class="title"> Als laatste </div><p> Het masker hydrateert diep het haar, voorkomt uitdroging en gespleten haarpunten. </p></div></div></div></div></div></section><section class="section__3 hidden"><div class="container"><div class="girl_left_bg"><div class="row"><div class="col-md-8 col-md-offset-4 padding"><div class="h4"> Regelmatig gebruik van <b> Princess Hair haarmasker </b></div><div class="h1"> maakt <span> uw haar voller, </span></div><div class="fuck__line"><div class="padding_lft"><div> het wordt <span> zijdezacht </span></div><div> en <span> ziet er goed verzorgd uit </span> , en is geschikt voor ieder kapsel </div></div></div></div></div></div></div></section><section class="section__4"><div class="hidden"><img alt class="layer1" src="img/layer__2.png"><img alt class="layer2" src="img/layer__2.png"><img alt class="layer4" src="img/leaf2.png"></div><div class="container"><div class="clearfix"><div class="table"><div class="left"><div class="h1"><img alt class="layer3" src="img/leaf2.png"><span> Aminozuren en </span><div> plantaardige </div><div> extracten </div></div><div class="fuck__line_2"> Het masker bevat natuurlijke bestanddelen van <b> oliën, vitamines en ceramides </b> . </div><div class="text"> Het middel heeft een positieve invloed op de haarfollikels, die de diameter van haarschacht vergroten, <b> en verlengen daarmee de fase van de actieve groei </b> . </div></div><div class="right hidden"><div class="relative"><img alt class="product__2" src="img/product.png"><img alt class="ho" src="img/ho.png"><img alt class="leaf" src="img/leaf.png"></div></div></div></div><div class="clearfix relative"><div class="text__2"><img alt class="formula" src="img/formula.png"><img alt class="circle3" src="img/circle3.png"><div class="h3"> Het actieve aminozuur </div><div class="h2 center"> L-cysteine </div></div></div><div class="clearfix"><div class="table table__2"><div class="left"><div class="relative"><img alt class="product__2 respons__img" src="img/circle2.jpg"></div></div><div class="right"><div class="fuck__line_3"> L-cysteine <div><b> is het primaire aminozuur </b> van de groep endogenen. </div></div><div class="text"><p> Het is verantwoordelijk voor de vorming van <b> keratine - de bouwsteen van het haar </b> . L-cysteine dringt onmiddellijk door tot in de haarwortels en versterkt hen van binnenuit - over de volledige lengte. </p><p> Daarom wordt het haar al na de eerste toepassing voller, <b> gezonder en glanzend. </b></p></div></div></div></div></div></section><section class="section__5 clearfix"><div class="hidden"><div class="container"><div class="fuck__line_4 col-md-9"> Voel het effect van <span> moeder natuur </span><img alt class="list2" src="img/list2.png"></div></div></div><div class="container hidden"><div class="row"><div class="characteristics clearfix"><img alt class="e" src="img/e.png"><div class="col-md-6"><div class="item_1"><div class="caption"><span> 1. </span> Versterkend </div><div class="block"><div class="left"><div class="relative"><div class="img img_1"><img alt src="img/img_1.jpg"></div><div class="img img_2"><img alt src="img/img_2.jpg"></div></div></div><div class="right"><div class="title"> ARGANOLIE + KLISWORTELOLIE </div><div class="description"><b> Verbetert de kracht </b> en de grootte van de haarfollikels, zodat zij niet via de huid verloren gaan. </div></div></div></div><div class="item_2"><div class="caption"><span> 2. </span> Versnelling van de haargroei </div><div class="block"><div class="left"><div class="relative"><div class="img img_1"><img alt src="img/img_3.jpg"></div><div class="img img_2"><img alt src="img/img_4.jpg"></div></div></div><div class="right"><div class="title"> KOKOSOLIE, KANEELOLIE </div><div class="description"> Het complex van oliën versterkt de <b> micro bloedcirculatie </b> en wekt de sluimerende haarfollikels. </div></div></div><div class="center mb__2"><img alt src="img/image28.jpg"></div></div></div><div class="col-md-6"><div class="item_2 item_3"><div class="caption"><span> 3. </span> Voeding </div><div class="block"><div class="left"><div class="relative"><div class="img img_1"><img alt src="img/img_5.jpg"></div><div class="img img_2"><img alt src="img/img_6.jpg"></div></div></div><div class="right"><div class="title"> VITAMINE A + Vitamine E </div><div class="description"> De vitamines dringen diep door in de haarstructuur, <b> herstellen de corticale laag </b> en maken de haarschubben glad. </div></div></div></div><div class="item_4"><div class="caption"><span> 4. </span> Bescherming </div><div class="block"><div class="left"><div class="relative"><div class="img img_1"><img alt src="img/img_7.jpg"></div><div class="img img_2"><img alt src="img/img_8.jpg"></div></div></div><div class="right"><div class="title"> ACORUSEXTRACT+ KAMILLE- EXTRACT </div><div class="description"> Deze combinatie van extracten <b> beschermen het haar tegen stress </b> , veroudering en vernietiging van het natuurlijke keratine. </div></div></div></div></div></div></div></div><div class="characteristics2 clearfix"><div class="container"><div class="row"><div class="col-md-8"><div class="h2"> Versnelt de haargroei tot <div> 4 centimeter </div></div><div class="text__right"><img alt class="hidden" src="img/arrow.png"><span class="h3"> per maand </span></div><div class="clearfix"><div class="table_col"><button class="btn toform"> Bestel nu </button></div><div class="table_col2 hidden"><img alt src="img/arrow2.png"></div></div></div><img alt class="woomen2 hidden" src="img/woomen2.png"></div></div></div></section><!-- <section class="reviews">
					<div class="doctor__reviews">
						<div class="container">
							<div class="row">
								<div class="col-md-7">
									<h2> Professionele
								<div> opinie</div>
							</h2></div>
								<div class="col-md-5">
									<div class="stam hidden">
										<div class="block_kakoito">
											<span class="img"><img src="img/tick.png" alt=""/></span>
											<span class="text">  Goedgekeurd door  <br>   specialisten</span>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-5">
									<div class="doctor">
										<div class="img"><img src="img/woomen3.jpg" alt="" class="img__response" /></div>
										<div class="doc__name">
											<div class="h4"><span> Heleen Johannes </span>, </div>
											<span> trichologist </span>
										</div>
										<div class="signature hidden"><img src="img/signature.png" alt="" /></div>
									</div>
								</div>
								<div class="col-md-7">
									<div class="reviews__specialist">
										<div class="wrap">
									<p> Het effect van het milieu, stylen en kleuren
										<b>verzwakken uw haar</b>, vernietigen de disulfideverbindingen.
										<b>Het haar wordt dunner, breekt en valt uiteindelijk uit</b>. </p>
									<p> Om het haar gezond te houden, is het de moeite waard om u aan een aantal regels te houden:
										<b>eet gezond, geen stress en slaap minstens 7 uren per etmaal</b>. Helaas is dat niet altijd mogelijk. Daarom adviseer ik
										<b>om een haargroeimasker te gebruiken - Princess Hair</b>. Tegenwoordig, wordt het vaak gebruikt bij de wereld modeweken die in Parijs worden gehouden, voor snel herstel van het haar.
									</p>
									<p> Het actieve ingrediënt, L-cysteïne, herstelt de beschadigde haarstructuur, wat ervoor zorgt dat het
										<b class="turquoise"> dik en sterk</b> wordt, en de levensduur van elke individuele haar verlengt. Het natuurlijke fyto-complex in het masker
										<b class="turquoise"> verzorgt de haarwortels en de hoofdhuid.</b></p>

								</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section> --><section class="section__6"><div class="container"><div class="title"><div class="above"> Klanten </div><div class="under"> adviseren </div></div><ul class="bxslider"><li><div class="title"><span class="media"><img alt src="img/ava_1.jpg"></span><span class="name"> Carolien </span></div><div class="list_media"><img alt src="img/insta_1.jpg"></div><div class="like"><img alt src="img/icons.jpg"></div><div class="comment"><span class="comment__tags"> #ilovemyhair #princesshair #hair #beautygram </span> Mijn kleine geheimpje maakt mijn haar onweerstaanbaar... </div><div class="date"> 5 dagen geleden </div><div class="footer_img"><img alt src="img/footer__img.jpg"></div></li><li><div class="title"><span class="media"><img alt src="img/ava_2.jpg"></span><span class="name"> Adinda van Steijn </span></div><div class="list_media"><img alt src="img/insta_2.jpg"></div><div class="like"><img alt src="img/icons.jpg"></div><div class="comment"><span class="comment__tags"> #princesshair #loveyourselffirst #hairdressermagic #beautyday </span> Bedankt mam en pap voor zulk haar en Princess haarmasker))) </div><div class="date"> 6 dagen geleden </div><div class="footer_img"><img alt src="img/footer__img.jpg"></div></li><li><div class="title"><span class="media"><img alt src="img/ava_3.jpg"></span><span class="name"> perfectlady85 </span></div><div class="list_media"><img alt src="img/insta_3.jpg"></div><div class="like"><img alt src="img/icons.jpg"></div><div class="comment"><span class="comment__tags"> #princess #beauty #princesshair #lovemyself </span> Ongelooflijk haar! Iedereen is verrukt. </div><div class="date"> 7 dagen geleden </div><div class="footer_img"><img alt src="img/footer__img.jpg"></div></li><li><div class="title"><span class="media"><img alt src="img/ava_4.jpg"></span><span class="name"> Margo90 </span></div><div class="list_media"><img alt src="img/insta_4.jpg"></div><div class="like"><img alt src="img/icons.jpg"></div><div class="comment"><span class="comment__tags"> #goodhairday #blessed #ilovemyself #princesshair </span> Mijn haar is nu gewoonweg prachtig))) Iedereen ziet groen van jaloezie </div><div class="date"> 15 dagen geleden </div><div class="footer_img"><img alt src="img/footer__img.jpg"></div></li><li><div class="title"><span class="media"><img alt src="img/ava_5.jpg"></span><span class="name"> bluegirls </span></div><div class="list_media"><img alt src="img/insta_5.jpg"></div><div class="like"><img alt src="img/icons.jpg"></div><div class="comment"><span class="comment__tags"> #haircolor #beautyroutine #princesshair #iwokeuplikethis </span> Gosh, kijk eens naar de kleur alleen! </div><div class="date"> 17 dagen geleden </div><div class="footer_img"><img alt src="img/footer__img.jpg"></div></li><li><div class="title"><span class="media"><img alt src="img/ava_6.jpg"></span><span class="name"> prettywomanangela </span></div><div class="list_media"><img alt src="img/insta_6.jpg"></div><div class="like"><img alt src="img/icons.jpg"></div><div class="comment"><span class="comment__tags"> #beautyguru #princesshair #iloveit #love #hairstyling </span> Klaar voor het bal. Wacht maar eens af, mannen! </div><div class="date"> 17 dagen geleden </div><div class="footer_img"><img alt src="img/footer__img.jpg"></div></li><!--<li>
									<div class="title"><span class="media"><img alt="" src="img/ava_7.jpg"/></span><span
									   class="name"> Carolien </span></div>
									<div class="list_media"><img alt="" src="img/insta_7.jpg"/></div>
									<div class="like"><img alt="" src="img/icons.jpg"/></div>
									<div class="comment">
										Mijn kleine geheimpje maakt mijn haar onweerstaanbaar...
									</div>
									<div class="date"> 19 dagen geleden</div>
									<div class="footer_img"><img alt="" src="img/footer__img.jpg"/></div>
								</li>--><!--<li>
									<div class="title"><span class="media"><img alt="" src="img/ava_8.jpg"/></span><span
									   class="name">   Adinda van Steijn </span></div>
									<div class="list_media"><img alt="" src="img/insta_8.jpg"/></div>
									<div class="like"><img alt="" src="img/icons.jpg"/></div>
									<div class="comment">
										Bedankt mam en pap voor zulk haar en Princess haarmasker)))
									</div>
									<div class="date"> 20 dagen geleden</div>
									<div class="footer_img"><img alt="" src="img/footer__img.jpg"/></div>
								</li>
								<li>
									<div class="title"><span class="media"><img alt="" src="img/ava_9.jpg"/></span><span
									   class="name">   Adinda van Steijn </span></div>
									<div class="list_media"><img alt="" src="img/insta_9.jpg"/></div>
									<div class="like"><img alt="" src="img/icons.jpg"/></div>
									<div class="comment">
										Bedankt mam en pap voor zulk haar en Princess haarmasker)))
									</div>
									<div class="date"> 21 dagen geleden</div>
									<div class="footer_img"><img alt="" src="img/footer__img.jpg"/></div>
								</li>--></ul><!--<p class="disclaimer"></p>--></div></section><section class="section__7 hidden"><div class="container"><div class="left"><div class="logo"><img alt src="img/logo_white.svg"></div><div class="h1"> geschikt voor <div> alle soorten </div><span> haar </span></div></div><div class="right"><div class="product"><img alt src="img/product.png"></div><div class="fuck__line_4"><ul class="list"><li><div class="img"><img alt src="img/icon14.png"></div><span> Droog, broos </span></li><li><div class="img"><img alt src="img/icon14.png"></div><span> Vet </span></li><li><div class="img"><img alt src="img/icon14.png"></div><span> Normaal </span></li><li><div class="img"><img alt src="img/icon14.png"></div><span> Beschadigd </span></li></ul></div></div></div></section><section class="section__8"><div class="container"><div class="row"><div class="woomen4 hidden"><img alt src="img/woomen4.png"></div><div class="col-md-7 col-md-offset-5 mb__4"><div class="h1"> Aanbrengen <span> tips </span></div><div class="item"><div class="img"><div class="ava"><img alt src="img/sovet_1.jpg"></div></div><div class="text"><div class="title"> Aanbrengen </div><div class="content__text"> Wassen het haar, droog het een beetje en <b> breng het masker aan </b> . </div></div></div><div class="item"><div class="img"><div class="ava"><img alt src="img/sovet_2.jpg"></div></div><div class="text"><div class="title"> Voeding </div><div class="content__text"> Voor dagelijkse haarverzorging, laat het masker <b> 3-5 minuten </b> in uw haar zitten en spoel het grondig uit met warm water. </div></div></div><div class="item"><div class="img"><div class="ava"><img alt src="img/sovet_3.jpg"></div></div><div class="text"><div class="title"> Versnelling van de haargroei </div><div class="content__text"> Voor een meer opvallend effect, <b> breng een laag aan op het haar, en houdt het met een handdoek warm </b> . Spoel het masker na 30 minuten uit. </div></div></div></div></div></div></section><section class="section__9 hidden"><div class="container"><div class="row"><div class="col-md-5"><div class="fuck__line_5"> Regelmatig gebruik van <b> Princess Hair </b> masker voor haargroei zorgt dat het haar lange tijd </div></div><div class="col-md-7"><div class="h1"> sterk en <span> mooi </span> blijft </div></div></div></div></section><footer><div class="container container__1"><div class="row"><div class="col-md-10"><div class="left hidden"><div class="logo"><img alt src="img/logo_white.svg"></div><div class="stamp"><img alt src="img/stamp2.png"></div></div><div class="right hidden"><div class="discont"><img alt src="img/discount.png"><span> Korting </span></div></div><div class="h1"><div class="left__text"> Uw haar <span class="visible"> LANG, VOL EN GLANZEND </span></div><div class="right__text hidden"> dik </div></div></div></div><div class="row mb__4"><div class="col-md-8"><div class="h2 hidden"> glanzend </div><div class="h3 hidden"> lang </div><div class="product clearfix relative"><div class="visible"><div class="discont"><img alt src="img/discount__mobile2.png"><span> Korting </span></div></div><div class="price"><div class="old_price"><span class="old_price_value js_old_price_curs"> 98 € </span></div><div class="new_price"><span class="new_price_value js_new_price_curs"> 49 €* </span></div></div><img alt src="img/product.png"></div></div><div class="col-md-4 mob__top"><div class="form"><form action id="order_form" method="post"><input name="template_name" type="hidden" value="fNL6ELYgP5OxNZ7"><input name="country_code" type="hidden" value="NL"><input name="shipment_price" type="hidden" value="0"><input name="total_price" type="hidden" value="49.0"><input name="price_vat" type="hidden" value="0.0"><input name="shipment_vat" type="hidden" value="0.0"><input name="total_price_wo_shipping" type="hidden" value="49.0"><input name="price" type="hidden" value="49"><input name="old_price" type="hidden" value="98"><input name="currency" type="hidden" value="€"><input name="package_id" type="hidden" value="1"><input name="package_prices" type="hidden" value="{'1': {'old_price': 98, 'price': 49, 'price_w_vat': 49, 'shipment_price': 0}, '3': {'old_price': 196, 'price': 98, 'price_w_vat': 98, 'shipment_price': 0}, '5': {'old_price': 294, 'price': 147, 'price_w_vat': 147, 'shipment_price': 0}}"><div class="title"> Bestelformulier </div><div class="select relative"><select id="country_code_selector" name="country_code"><option value="NL"> Nederland </option><option value="BE"> België </option></select></div><input name="name" placeholder="Uw naam" type="text"><input class="only_number" name="phone" placeholder="Telefoonnummer" type="text"><button class="js_submit btn"><span> bestel nu </span></button></form></div></div></div><p class="remark"><b> * </b> Houdt u er rekening mee dat lokale BTW tarieven kunnen variëren afhankelijk van de voorschriften van het land waaruit u onze producten bestelt. Onze Sales/Klantenservice medewerkers helpen u hier graag verder mee. </p></div><div class="container"><div class="center"></div></div></footer></div><script src="js/js.cookie.min.js" type="text/javascript">
  </script><script>
   $(document).ready(function () {
        
        
        try {
            moment.locale("");
            $('.day-before').text(moment().subtract(1, 'day').format('D.MM.YYYY'));
            $('.day-after').text(moment().add(1, 'day').format('D.MM.YYYY'));
        } catch (e) { console.log('moment problems!'); }
    });
  </script><!--retarget--><!--retarget--><div class="ac_footer"><span> © 2019 Copyright. All rights reserved. </span><br><a href="//dadbab.info/content/shared/html/policy_en.html" target="_blank"> Privacy policy </a> | <a href="http://ac-feedback.com/report_form/"> Report </a><p></p></div></body></html>