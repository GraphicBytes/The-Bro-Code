<?php
$pagetitle = "The Bro Code Meme Maker";
$pagedescription = "The Bro Code Meme Maker - No Watermarks";
$canonical = "https://brocode.org/meme-maker/";
$nofollow = 1;
$sfw = 2;
include($php_base_directory . '/header.php');
?>


<div class="container">
  <main class="content">

    <div class="content-block  bottom-padding">
      <h1 class="page-header hero">
        <?php echo $pagetitle; ?>
        <span class="hero-link-bg-image" style="background-image:url('<?php echo $static_url; ?>/images/tiles/fist-bump-large.jpg');"></span>
      </h1>
    </div>

    <div class="content-block meme-maker">

      <div class="choice-section">

        <h3 class="page-header sub-header">Select an image or use your own</h3>


        <div class="page-header meme-select">
          <input type="file" class="custom-file-input" id="meme-input">
          <label class="custom-file-label meme-maker-custom-file-label" for="meme-input">Choose your own image</label>

          <span class="hero-link-bg-image" style="background-image:url('<?php echo $static_url; ?>/images/tiles/phone-in-hand-large.jpg');"></span>
        </div>

        <div>
          <div class="grid memes-container">
            <div class="grid-sizer"></div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/3_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/3.jpg" alt="Two Buttons" img-height="908" img-width="600">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/8_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/8.jpg" alt="Left Exit 12 Off Ramp" img-height="767" img-width="804">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/9_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/9.jpg" alt="Bernie I Am Once Again Asking For Your Support" img-height="750" img-width="750">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/10_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/10.jpg" alt="Mocking Spongebob" img-height="353" img-width="502">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/11_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/11.jpg" alt="Gru's Plan" img-height="449" img-width="700">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/1_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/1.jpg" alt="Drake Hotline Bling" img-height="1200" img-width="1200">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/2_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/2.jpg" alt="Distracted Boyfriend" img-height="800" img-width="1200">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/4_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/4.jpg" alt="Running Away Balloon" img-height="1024" img-width="761">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/5_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/5.jpg" alt="Change My Mind" img-height="361" img-width="482">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/17_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/17.jpg" alt="Waiting Skeleton" img-height="403" img-width="298">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/19_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/19.jpg" alt="Blank Nut Button" img-height="446" img-width="600">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/21_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/21.jpg" alt="Epic Handshake" img-height="645" img-width="900">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/22_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/22.jpg" alt="Disaster Girl" img-height="375" img-width="500">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/12_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/12.jpg" alt="Expanding Brain" img-height="1202" img-width="857">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/13_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/13.jpg" alt="Batman Slapping Robin" img-height="387" img-width="400">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/14_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/14.jpg" alt="Woman Yelling At Cat" img-height="438" img-width="680">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/20_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/20.jpg" alt="Monkey Puppet" img-height="768" img-width="923">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/15_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/15.jpg" alt="Boardroom Meeting Suggestion" img-height="649" img-width="500">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/15_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/15.jpg" alt="Always Has Been" img-height="540" img-width="960">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/29_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/29.jpg" alt="They're The Same Picture" img-height="1524" img-width="1363">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/30_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/30.jpg" alt="One Does Not Simply" img-height="335" img-width="568">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/31_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/31.jpg" alt="Surprised Pikachu" img-height="1893" img-width="1893">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/32_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/32.jpg" alt="Clown Applying Makeup" img-height="798" img-width="750">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/33_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/33.jpg" alt="Hide the Pain Harold" img-height="601" img-width="480">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/23_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/23.jpg" alt="I Bet He's Thinking About Other Women" img-height="930" img-width="1654">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/24_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/24.jpg" alt="Tuxedo Winnie The Pooh" img-height="582" img-width="800">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/25_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/25.jpg" alt="Sad Pablo Escobar" img-height="709" img-width="720">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/26_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/26.jpg" alt="Inhaling Seagull" img-height="2825" img-width="1269">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/27_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/27.jpg" alt="Is This A Pigeon" img-height="1425" img-width="1587">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/28_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/28.jpg" alt="X, X Everywhere" img-height="1440" img-width="2118">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/41_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/41.jpg" alt="Y'all Got Any More Of That" img-height="471" img-width="600">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/42_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/42.jpg" alt="This Is Fine" img-height="282" img-width="580">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/43_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/43.jpg" alt="The Rock Driving" img-height="700" img-width="568">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/44_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/44.jpg" alt="Oprah You Get A" img-height="465" img-width="620">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/45_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/45.jpg" alt="This Is Where I'd Put My Trophy If I Had One" img-height="418" img-width="300">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/46_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/46.jpg" alt="Guy Holding Cardboard Sign" img-height="702" img-width="700">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/34_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/34.jpg" alt="The Scroll Of Truth" img-height="1236" img-width="1280">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/35_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/35.jpg" alt="Laughing Leo" img-height="470" img-width="470">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/36_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/36.jpg" alt="American Chopper Argument" img-height="1800" img-width="640">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/37_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/37.jpg" alt="Bike Fall" img-height="680" img-width="500">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/38_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/38.jpg" alt="Roll Safe Think About It" img-height="395" img-width="702">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/39_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/39.jpg" alt="Ancient Aliens" img-height="437" img-width="500">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/40_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/40.jpg" alt="Who Killed Hannibal" img-height="1440" img-width="1280">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/56_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/56.jpg" alt="Trump Bill Signing" img-height="1529" img-width="1866">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/57_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/57.jpg" alt="Futurama Fry" img-height="414" img-width="552">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/58_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/58.jpg" alt="Star Wars Yoda" img-height="714" img-width="620">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/59_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/59.jpg" alt="Third World Success Kid" img-height="500" img-width="500">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/60_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/60.jpg" alt="Leonardo Dicaprio Cheers" img-height="400" img-width="600">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/61_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/61.jpg" alt="Don't You Squidward" img-height="333" img-width="500">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/62_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/62.jpg" alt="Sleeping Shaq" img-height="631" img-width="640">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/63_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/63.jpg" alt="Success Kid" img-height="500" img-width="500">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/64_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/64.jpg" alt="The Most Interesting Man In The World" img-height="690" img-width="550">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/47_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/47.jpg" alt="Unsettled Tom" img-height="550" img-width="680">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/48_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/48.jpg" alt="Spongebob Ight Imma Head Out" img-height="960" img-width="822">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/49_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/49.jpg" alt="Doge" img-height="620" img-width="620">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/50_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/50.jpg" alt="Finding Neverland" img-height="600" img-width="423">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/51_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/51.jpg" alt="Evil Kermit" img-height="325" img-width="700">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/52_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/52.jpg" alt="Third World Skeptical Kid" img-height="426" img-width="426">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/53_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/53.jpg" alt="Hard To Swallow Pills" img-height="979" img-width="680">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/54_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/54.jpg" alt="Marked Safe From" img-height="499" img-width="618">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/55_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/55.jpg" alt="Grandma Finds The Internet" img-height="480" img-width="640">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/73_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/73.jpg" alt="Cute Cat" img-height="532" img-width="480">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/74_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/74.jpg" alt="Who Would Win?" img-height="500" img-width="802">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/75_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/75.jpg" alt="X All The Y" img-height="355" img-width="500">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/76_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/76.jpg" alt="Be Like Bill" img-height="907" img-width="913">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/77_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/77.jpg" alt="Bad Luck Brian" img-height="562" img-width="475">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/78_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/78.jpg" alt="Marvel Civil War 1" img-height="734" img-width="423">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/79_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/79.jpg" alt="I'll Just Wait Here" img-height="550" img-width="491">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/80_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/80.jpg" alt="See Nobody Cares" img-height="676" img-width="620">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/81_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/81.jpg" alt="Grumpy Cat" img-height="617" img-width="500">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/65_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/65.jpg" alt="Brace Yourselves X is Coming" img-height="477" img-width="622">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/66_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/66.jpg" alt="That Would Be Great" img-height="440" img-width="526">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/67_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/67.jpg" alt="Scared Cat" img-height="464" img-width="620">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/68_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/68.jpg" alt="Jack Sparrow Being Chased" img-height="375" img-width="500">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/69_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/69.jpg" alt="Squidward" img-height="750" img-width="500">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/70_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/70.jpg" alt="Imagination Spongebob" img-height="366" img-width="500">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/71_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/71.jpg" alt="First World Problems" img-height="367" img-width="552">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/72_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/72.jpg" alt="Look At Me" img-height="300" img-width="300">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/90_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/90.jpg" alt="I Should Buy A Boat Cat" img-height="368" img-width="500">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/91_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/91.jpg" alt="Laughing Men In Suits" img-height="333" img-width="500">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/92_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/92.jpg" alt="Put It Somewhere Else Patrick" img-height="604" img-width="343">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/93_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/93.jpg" alt="Keep Calm And Carry On Red" img-height="704" img-width="500">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/94_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/94.jpg" alt="Creepy Condescending Wonka" img-height="545" img-width="550">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/95_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/95.jpg" alt="Say it Again, Dexter" img-height="900" img-width="698">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/82_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/82.jpg" alt="Evil Toddler" img-height="332" img-width="500">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/83_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/83.jpg" alt="I'm The Captain Now" img-height="350" img-width="478">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/84_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/84.jpg" alt="Uncle Sam" img-height="833" img-width="620">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/85_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/85.jpg" alt="Y U No" img-height="500" img-width="500">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/86_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/86.jpg" alt="Peter Parker Cry" img-height="992" img-width="400">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/87_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/87.jpg" alt="But That's None Of My Business" img-height="600" img-width="600">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/88_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/88.jpg" alt="Too Damn High" img-height="316" img-width="420">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/89_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/89.jpg" alt="Yo Dawg Heard You" img-height="323" img-width="500">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/96_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/96.jpg" alt="Black Girl Wat" img-height="626" img-width="599">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/97_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/97.jpg" alt="Mugatu So Hot Right Now" img-height="497" img-width="620">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/98_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/98.jpg" alt="Dr Evil Laser" img-height="405" img-width="500">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/18_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/18.jpg" alt="Panik Kalm Panik" img-height="881" img-width="640">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/99_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/99.jpg" alt="Presidential Alert" img-height="534" img-width="920">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/6_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/6.jpg" alt="Buff Doge vs. Cheems" img-height="720" img-width="937">
            </div>

            <div class="grid-item">
              <img src="<?php echo $static_url; ?>/meme-maker-images/7_thumb.jpg" full-img-src="<?php echo $static_url; ?>/meme-maker-images/7.jpg" alt="UNO Draw 25 Cards" img-height="494" img-width="500">
            </div>

          </div>
        </div>
      </div>

      <div class="edit-section">

        <h3 class="page-header sub-header">CREATE YOUR MEME</h3>

        <div class="page-header meme-select">
          <div class="back-to-memes meme-maker-custom-file-label">GO BACK</div>
          <span class="hero-link-bg-image" style="background-image:url('<?php echo $static_url; ?>/images/tiles/phone-in-hand-large.jpg');"></span>
        </div>

        <div class="meme-maker-creation-area">
          <div class="meme-maker-creation-split">
            <div class="meme-preview">
              <div class="fabric-canvas-wrapper"></div>
            </div>
          </div>
          <div class="meme-maker-creation-split right">

            <div class="meme-maker-editor-row ">
              <div class="page-header meme-header">
                TEXT
              </div>
              <div class="meme-maker-editor-row flex" id="cp-text">
                <textarea class="meme-maker-text" id="text" placeholder="Type your text here"></textarea>

                <span class="meme-maker-editor-colour-container">
                  <span class="input-group-text colorpicker-input-addon" id="text-color" value="#ffffff"><i style="background: rgb(255, 255, 255);"></i></span>
                </span>
              </div>
            </div>

            <div class="meme-maker-editor-row flex">
              <div class="meme-maker-editor-row three-quart">
                <div class="page-header meme-header">
                  FONT
                </div>

                <select class="form-control text-method" name="font-family" id="font-family">
                  <option value="Arial">Arial</option>
                  <option value="Arial Black">Arial Black</option>
                  <option value="Comic Sans Ms">Comic Sans Ms</option>
                  <option value="Impact" selected>Impact</option>
                  <option value="Times New Roman">Times New Roman</option>
                  <option value="Trebuchet MS">Trebuchet MS</option>
                </select>

              </div>

              <div class="meme-maker-editor-row quart">
                <div class="page-header meme-header">
                  SIZE
                </div>
                <div class="meme-maker-editor-row flex">
                  <input class="meme-maker-text half-height" type="number" value="150" id="font-size">
                </div>
              </div>
            </div>

            <div class="meme-maker-editor-row flex">
              <div class="meme-maker-editor-row">
                <div class="page-header meme-header">
                  SCALE
                </div>
                <div class="range-slider-container">
                  <div class="range-slider-container-inner">
                    <input type="range" class="meme-maker-scale" id="scale" min="0.1" step="0.01">
                  </div>
                </div>
              </div>

              <div class="meme-maker-editor-row">
                <div class="page-header meme-header">
                  OPACITY
                </div>
                <div class="range-slider-container">
                  <div class="range-slider-container-inner">
                    <input type="range" class="meme-maker-scale" id="opacity" min="0" max="100" value="100">
                  </div>
                </div>
              </div>
            </div>


            <div class="meme-maker-editor-row flex">
              <div class="meme-maker-editor-row ">
                <div class="page-header meme-header">
                  BORDER
                </div>
                <div class="meme-maker-editor-row flex cp cp-black" id="cp-stroke">
                  <input class="meme-maker-text full-width" type="number" value="8" id="stroke-width" min="0" max="20" placeholder="0">
                  <span class="input-group-append">
                    <span class="input-group-text colorpicker-input-addon" id="stroke-color" value="#000000"><i></i></span>
                  </span>
                </div>
              </div>

              <div class="meme-maker-editor-row ">
                <div class="page-header meme-header">
                  SHADOW
                </div>
                <div class="meme-maker-editor-row flex cp cp-black" id="cp-shadow">
                  <input class="meme-maker-text full-width" type="number" value="0" id="shadow-depth" min="0" max="20" placeholder="0">
                  <span class="input-group-append">
                    <span class="input-group-text colorpicker-input-addon" id="shadow-color" value="#000000"><i></i></span>
                  </span>
                </div>
              </div>

              <div class="meme-maker-editor-row">
                <div class="page-header meme-header">
                  BG COLOUR
                </div>

                <div class="meme-maker-editor-row flex cp cp-black" id="cp-background">
                  <button class="btn btn-warning meme-maker-bg-button edit-btn text-method" id="bg-option" value="" data><i class="fas fa-fill-drip"></i></button>
                  <span class="input-group-append">
                    <span class="input-group-text colorpicker-input-addon" id="bg-color" value="#000000"><i></i></span>
                  </span>
                </div>

              </div>
            </div>



            <div class="meme-maker-editor-row">
              <button class="btn btn-warning meme-add-text-btn" id="add-text">Add text</button>
            </div>


            <div class="meme-maker-editor-row ">
              <label class="btn btn-warning mb-0 meme-maker-add-image-button" for="add-image">Add Image</label>
              <input type="file" class="custom-file-input d-none" id="add-image">
            </div>


            <div class="meme-maker-editor-row">
              <button class="btn btn-success meme-generate-btn" id="generate-meme">Generate Meme</button>
            </div>









            <div class="hiddentools">
              <input type="hidden" id="underline" value="true" data>
              <input type="hidden" id="italic" value="true" data>
              <input type="hidden" id="underline" value="true" data>
              <label class="btn btn-warning active align">
                <input type="radio" value="left" name="align" id="left" checked>
              </label>
              <label class="btn btn-warning align">
                <input type="radio" value="center" name="align" id="center">
              </label>
              <label class="btn btn-warning align">
                <input type="radio" value="right" name="align" id="right">
              </label>
            </div>

            <div class="col-12 alert-container alert alert-danger" style="display: none;"></div>

          </div>
        </div>
      </div>

      <script>
        // Intialize color picker
        $('#cp-text').colorpicker({
          fallbackColor: 'rgb(255, 255, 255)',
          input: '',
        });

        $('.cp-black').colorpicker({
          fallbackColor: '#000000',
          input: '',
        })

        // Intialize font-family select
        $('select').selectpicker({
          style: 'new-select',
        })
      </script>

    </div>

  </main>

  <aside id="sidebar" class="sidebar">
    <?php include($php_base_directory . '/sidebar.php'); ?>
  </aside>
</div>

<?php
include($php_base_directory . '/footer.php');
?>