<?php

namespace Anytv\MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Anytv\MainBundle\Entity\Faq;

class LoadFaqData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $faq = array();
        
        // any.TV
        
        $faq[] = array('question'=>'What is any.TV? &#8211; Video recommendation revenue!',
                       'answer'=>'<p>any.TV is a new kind of YouTube Network that pays recommendation revenue!</p>'.
                                  '<p>Highlights:</p>'.
                                  '<ul>'.
                                    '<li>No contract</li>'.
                                    '<li>New revenue stream: recommendation revenue</li>'.
                                    '<li>2 partnerships at once: stay partnered with your current Network</li>'.
                                    '<li>10% lifetime bonus for recommending any.TV to your friends and partners</li>'.
                                  '</ul>'.
                                  '<div style="max-width:640px;max-height:360px;">'.
                                    '<div>'.
                                      '<iframe title="YouTube video player" width="640" height="360" src="http://www.youtube.com/embed/RvPsDhrtgZg?list=PLyI74zGGymu8k7eVhGPcVSh3nKljHfiVX" marginwidth="0" marginheight="0" frameborder="0" allowfullscreen></iframe>'.
                                    '</div>'.
                                  '</div>'.
                                  '<p>Learn more on our website: <a href="http://www.any.tv">www.any.tv</a></p>',
                       'sortOrder'=>1,
                       'categories'=>array('any.TV')
                       );
        
        $faq[] = array('question'=>'Why did you leave TGN, George? &#8211; Professional differences and&#8230;',
                       'answer'=>'<p>TGN has many good people and I wish them well.</p>'.
                                  '<p>I (George) chose to leave because of professional differences, and I saw the opportunity to do something new and exciting with any.TV.</p>'.
                                  '<p>We now have 5,000 YouTube partners, growing at 1 new partner per hour! We &#8211; the <a href="http://www.any.tv/staff">entire any.TV team</a> - are  friends, welcoming new friends, and we are leaders who make the decisions that grow any.TV.</p>'.
                                  '<p>Hope this helps.</p>',
                       'sortOrder'=>2,
                       'categories'=>array('any.TV')
                       );
        
        $faq[] = array('question'=>'How do I make my own Network?',
                       'answer'=>'<p>To make your own Network, watch the video below and start building your Network with any.TV!</p>'.
                                  '<p>Simply share your Refer-a-Friend link, inviting people to sign up :-)</p>'.
                                  '<p>George created the any.TV Network as a franchise model to support Networks like yours. Before any.TV, George created and built the TGN Network from the ground up. He sold it to BroadbandTV and exited completely in Oct, 2012.</p>'.
                                  '<p>That is one reason George sold TGN, because it was too difficult to help YouTubers build their own Networks. What we needed was a new kind of YouTube Network built on a new revenue stream - recommendation revenue - with a franchise model, and that is any.TV.</p>'.
                                  '<div style="max-width:640px;max-height:360px;">'.
                                    '<div>'.
                                      '<iframe title="YouTube video player" width="640" height="360" src="http://www.youtube.com/embed/Hs1Tq_Mi_Yg?list=PLyI74zGGymu-Af4kOpHBLmGl3VleyDu-Y" marginwidth="0" marginheight="0" frameborder="0" allowfullscreen></iframe>'.
                                    '</div>'.
                                  '</div>',
                       'sortOrder'=>3,
                       'categories'=>array('any.TV')
                       );
        
        $faq[] = array('question'=>'Is any.TV a pyramid scheme?',
                       'answer'=>'<p>No!</p>'.
                                  '<p>Yes, we give a 10% lifetime bonus to everyone who recommends any.TV to their friends (see the "Refer-A-Friend" link for more info).</p>'.
                                  '<p>But, you do not get paid 10% for the referrals of your referrals. This 10% is a one-time one-level payout, George\'s way of saying: "Thank you for recommending any.TV!"</p>'.
                                  '<p>See this answer in video:</p>'.
                                  '<p><a href="http://www.youtube.com/watch?v=Hs1Tq_Mi_Yg&list=PLyI74zGGymu8k7eVhGPcVSh3nKljHfiVX#t=1m22s">http://www.youtube.com/watch?v=Hs1Tq_Mi_Yg&list=PLyI74zGGymu8k7eVhGPcVSh3nKljHfiVX#t=1m22s</a></p>',
                       'sortOrder'=>4,
                       'categories'=>array('any.TV')
                       );
        
        $faq[] = array('question'=>'I have more questions!',
                       'answer'=>'<p>Great!</p>'.
                                  '<p>See the full any.TV FAQ spreadsheet at:<br><a href="http://www.any.tv/faq-spreadsheet/">www.any.tv/faq-spreadsheet</a></p>',
                       'sortOrder'=>5,
                       'categories'=>array('any.TV')
                       );
        
        // dashboard
        
        $faq[] = array('question'=>'Which Play Now link should I use? - Any one!',
                       'answer'=>'<p>Use our Games Team <a href="http://www.games.tm/" target="_blank">www.games.tm<a> to get your Play Now links for games!</p>'.
                                  '<p>Or, use any Play Now link after signing in at <a href="http://www.any.tv/dashboard" target="_blank">www.any.tv/dashboard</a>. When someone from another country clicks it, they are automatically redirected by the dashboard to the correct country\'s Play Now link.</p>'.
                                  '<p>Simply put, you will get paid correctly by using any of the Play Now links!</p>'.
                                  '<p>For more info, see this video: <a href="http://www.youtube.com/watch?v=cgtxDAYaXr0&list=PLyI74zGGymu8k7eVhGPcVSh3nKljHfiVX#t=25s" target="_blank">www.youtube.com/watch?v=cgtxDAYaXr0&list=PLyI74zGGymu8k7eVhGPcVSh3nKljHfiVX#t=25s</a></p>',
                       'sortOrder'=>1,
                       'categories'=>array('Dashboard', 'Marketing')
                       );
        
        $faq[] = array('question'=>'If I use a Play Now link for USA, will I get paid for clicks from other countries?',
                       'answer'=>'<p>Yes!</p>'.
                                  '<p>The dashboard automatically redirects clicks from other countries to the correct Play Now link and you get paid appropriately to the country payout rate that the click came from.</p>'.
                                  '<p>Note: You don\'t get paid for the click. You get paid when people create a new account and start playing the game after clicking your Play Now link.</p>'.
                                  '<p>See this answer in video: <a href="http://www.youtube.com/watch?v=cUwPpAfwSNM&list=PLyI74zGGymu8k7eVhGPcVSh3nKljHfiVX#t=35s" target="_blank">www.youtube.com/watch?v=cUwPpAfwSNM&list=PLyI74zGGymu8k7eVhGPcVSh3nKljHfiVX#t=35s</a></p>',
                       'sortOrder'=>2,
                       'categories'=>array('Dashboard')
                       );
        
        $faq[] = array('question'=>'I get clicks but no conversions! - Why?',
                       'answer'=>'<p>There are many factors why conversions may not happen.</p>'.
                                  '<ol><li><b>Existing account</b> - Publishers only pay for new gamers, not returning ones. If people already have an account with that game or game website, there will not be a conversion.<br><br><br></li><li><b>Country</b> - It depends on the country where your clicks come from. Publishers only pay for new accounts from a few select countries, not all of them.<br><br><br></li><li><b>Ad-blockers</b> - These can block conversions in the same way they block ads from displaying.<br><br><br></li><li><b>Custom rules</b> - Ultimately, the publishers decide who qualifies as a conversion, and they may add custom rules to filter certain traffic.</li></ol>'.
                                  '<p>We see hundreds of conversions every day from our partners, so the system definitely works :-)</p>'.
                                  '<p>Our suggestion: Keep promoting your Play Now links around your videos and you will see conversions over time.</p>',
                       'sortOrder'=>3,
                       'categories'=>array('Dashboard', 'Marketing')
                       );
        
        $faq[] = array('question'=>'How can my account get blocked?',
                       'answer'=>'<p>There are two main ways your account can get blocked.</p>'.
                                  '<p><b>1. Video Required</b></p>'.
                                  '<p>If you do not use video next to your Play Now links, your account will get blocked.</p>'.
                                  '<p>any.TV is a new kind of YouTube Network and we require all our partners to use video or live streams next to their Play Now links. If you don\'t, how are we a new kind of YouTube Network?</p>'.
                                  '<p><b>2. Spam</b></p>'.
                                  '<p>If you get too many conversions from bots or automated scripts and you do not have legitimate conversions, your account will get blocked.</p>'.
                                  '<p>Publishers track how your leads perform. If they see no activity from the majority of your traffic, they will reject all your leads because they look like fraud. This happens when your promotions do not generate any active users.</p>'.
                                  '<p>Think of this from the publishers perspective: why would they pay for something that is not what they ordered? They ordered people who are genuinely interested in trying their product.</p>',
                       'sortOrder'=>4,
                       'categories'=>array('Dashboard')
                       );
        
        $faq[] = array('question'=>'Where is my Refer-a-Friend link?',
                       'answer'=>'<p>Sign into the dashboard at <a href="http://www.any.tv/dashboard" target="_blank">www.any.tv/dashboard</a>, you can see it on your control panel on the left.</p>',                  
                       'sortOrder'=>5,
                       'categories'=>array('Dashboard', 'Marketing')
                       );
        
        $faq[] = array('question'=>'Why are $0.00 games in the dashboard?',
                       'answer'=>'<p>All games become paying campaigns when game publishers decide to "greenlight" the games with a paying campaign. Publishers decide which countries to support, and they frequently pause and resume campaigns.</p>'.
                                  '<p>But you don\'t need to worry about all that.</p>'. 
                                  '<p>Just put any Play Now link beneath your videos, and you will automatically earn money when there is a paying campaign.</p>'. 
                                  '<p>That is why we have games with $0.00 payout. Those are the paused campaigns that will resume at some point. :-)</p>',
                       'sortOrder'=>6,
                       'categories'=>array('Dashboard', 'Payments')
                       );
        
        $faq[] = array('question'=>'Why are Conversion IPs the same?',
                       'answer'=>'<p>The Conversion IP column in your Conversion Report only shows the IPs of our dashboard servers, not the IPs of the people who click your Play Now links. Those IPs are hidden to protect users\' privacy.</p>'.
                                  '<p>If you need to see the users\' IPs because you suspect someone is botting your Play Now links, email <a href="mailto:support@any.tv">support@any.tv</a> and our admin can check.</p>',
                       'sortOrder'=>7,
                       'categories'=>array('Dashboard')
                       );
        
        $faq[] = array('question'=>'How can you track clicks from my YouTube videos? - Through our dashboard ...',
                       'answer'=>'<p>Our dashboard tracks every click and conversion from our Play Now links.</p>'.
                                  '<p>After you sign in to <a href="http://www.any.tv/dashboard" target="_blank">www.any.tv/dashboard</a>, click on "Offers" and pick one. Notice the Play Now link? Each Play Now link is unique to your account.</p>'. 
                                  '<p>Paste your Play Now links beneath your videos. Then, everyone who watches your videos and clicks your Play Now links is tracked by our dashboard!</p>',
                       'sortOrder'=>8,
                       'categories'=>array('Dashboard')
                       );
        
        $faq[] = array('question'=>'Where do I enter my PayPal info? - In the dashboard',
                       'answer'=>'<p>You can enter your PayPal email address on your profile.</p>',
                       'sortOrder'=>9,
                       'categories'=>array('Dashboard', 'Payments')
                       );
        
        $faq[] = array('question'=>'What are "zzz" games?',
                       'answer'=>'<p>These are the Yellow games.</p>'.
                                  '<p>Yellow games are paused campaigns, or campaigns waiting for the "green" light to become Green games.</p>'. 
                                  '<p>This means the game publisher is testing the conversions and is generally not paying for conversions yet (but in some cases, they do pay).</p>'. 
                                  '<p>Do not wait for a game to go Green! Use the "zzz" Play Now links.</p>'. 
                                  '<p>Why?</p>'.
                                  '<p>Because this helps convince game publishers to create a budget and start paying for conversions in more countries!</p>'.
                                  '<p>See this answer in video: <a href="http://www.youtube.com/watch?v=cUwPpAfwSNM&list=PLyI74zGGymu8k7eVhGPcVSh3nKljHfiVX#t=1m33s" target="_blank">http://www.youtube.com/watch?v=cUwPpAfwSNM&list=PLyI74zGGymu8k7eVhGPcVSh3nKljHfiVX#t=1m33s</a></p>',
                       'sortOrder'=>10,
                       'categories'=>array('Dashboard')
                       );
        
        $faq[] = array('question'=>'Where do I get my "Play Now" links?',
                       'answer'=>'<p>Step 1: Click <a href="http://www.games.tm/" target="_blank">games list</a> to see all the games.</p>'.
                                  '<p>Step 2: Get your Play Now links from <a href="http://www.any.tv/dashboard" target="_blank">www.any.tv/dashboard</a> and click the "Offers" tab.</p>',
                       'sortOrder'=>11,
                       'categories'=>array('Dashboard')
                       );
        
        $faq[] = array('question'=>'If my country is not in the offer, will I still get money?',
                       'answer'=>'<p>Yes!</p>'.
                                  '<p>It does not matter what country you live in. You will get views from all over the world, and it only matters which country each viewer is from :-)</p>',
                       'sortOrder'=>12,
                       'categories'=>array('Dashboard')
                       );
        
        // marketing
        
        $faq[] = array('question'=>'Do I need to make my own videos? - No!',
                       'answer'=>'<p>You must use video or live streams to promote your Play Now links!</p>'.
                                  '<p>If you don\'t make videos, simply pick your favorite video from YouTube or our Games Team <a href="http://www.games.tm/" target="_blank">www.games.tm</a> and embed it next to your Play Now link.</p>'.
                                  '<p>Yes, it is okay to use anyone\'s video to promote your Play Now links because YouTube allows you to embed any video anywhere you like. That\'s the whole point of YouTube: it is a public video library.</p>'. 
                                  '<p>See our Terms and Conditions for more info: <a href="http://www.any.tv/terms" target="_blank">www.any.tv/terms</a></p>'.
                                  '<p>Of course, we recommend you make your own videos or live streams so that you build your own audience and improve your skill as a content creator.</p>'.
                                  '<p>But if you have a popular website, Facebook or Twitter and do not want to create videos, simply find the most relevant videos on YouTube or our Games Team and embed them next to your Play Now links.</p>',
                       'sortOrder'=>1,
                       'categories'=>array('Marketing')
                       );
        
        $faq[] = array('question'=>'Are giveaways allowed? - Depends on ...',
                       'answer'=>'<p>Giveaways where Play Now links are one of the steps to enter are not allowed.</p>'.
                                  '<p>Why?</p>'.
                                  '<p>Think of this from the publisher\'s perspective: They are paying for sign-ups to their games with the expectation that each sign-up genuinely wants to play the game, not enter your giveaway.</p>'. 
                                  '<p>But contests featuring the game are encouraged!</p>'.
                                  '<p>For example: Challenge people to play a game: "How fast can you level up from 1 to 10? Click the Play Now link below to play! Post a video response proving your achievement and I will giveaway a game timecard to the winner."</p>'.
                                  '<p>These contests or giveaways create genuine interest in the game (who would play from level 1 to 10 if they have zero interest in the game?) which is exactly what game publishers want!</p>'. 
                                  '<p>See our Terms and Conditions for more info: <a href="http://www.any.tv/terms" target="_blank">www.any.tv/terms</a></p>',
                       'sortOrder'=>2,
                       'categories'=>array('Marketing')
                       );
        
        $faq[] = array('question'=>'Does it matter where I live? - No!',
                       'answer'=>'<p>You will get paid based on who clicks your links, not where you live.</p>'.
                                  '<p>For example, if 10 people from the USA click your Play Now link for a USA game and they start playing the game, you earn 10 conversions, even if you lived in Antarctica :-)</p>',
                       'sortOrder'=>3,
                       'categories'=>array('Marketing', 'Payments')
                       );
        
        $faq[] = array('question'=>'How do I promote my Network and any.TV?',
                       'answer'=>'<p>Thank you for promoting us any.TV!</p>'.
                                  '<p>We suggest using a script like this one when you email your friends or other YouTubers:</p>'.
                                  '<p>>>>></p>'. 
                                  '<p>Hello [insert_your_name],</p>'.
                                  '<p>I am messaging you today to invite you to come and check out our awesome recommendation revenue network, which was created by the ex-President of TGN: George Vanous, after he sold TGN to BroadbandTV in Oct, 2012.</p>'.
                                  '<p>You can earn a new recommendation revenue stream in addition to your YouTube ad revenue by adding a play now link - like this one: http://play.any.tv/SHAGQ - beneath your videos. This is exactly like Amazon.com buy now links, except instead of selling products, you are telling your fans where to go to play free-to-play games and they don\'t need to buy anything.</p>'.
                                  '<p>You earn about $1 per person who signs up to play a game like League of Legends or Star Wars: The Old Republic through your play now links. And every play now link is unique and custom-generated for you by our dashboard.</p>'.
                                  '<p>For more information, see this video: ➜ http://www.youtube.com/watch?v=UCqJAZuvUS0&list=PLyI74zGGymu8k7eVhGPcVSh3nKljHfiVX</p>'.
                                  '<p>Thank you for your time and keep doing what you are doing!</p>'.
                                  '<p>any.TV believes in you.</p>'.
                                  '<p>For more information, please contact me anytime.</p>'.
                                  '<p>E-mail: [example@any.tv]</p>'.
                                  '<p>Skype: [Example.example]</p>'.
                                  '<p><<<<</p>',
                       'sortOrder'=>4,
                       'categories'=>array('Marketing')
                       );
        
        $faq[] = array('question'=>'Can I get a higher payout? - Yes, if ...',
                       'answer'=>'<p>If publishers tell us your conversions are high quality, they will pay more for your traffic!</p>'.
                                  '<p>Everybody starts at the same payout rates per game per country, and publishers carefully track how the people you refer behave. If your way of promoting gets higher quality conversions, the publishers tell us and pay more for your traffic.</p>'.
                                  '<p>What is considered high quality conversions?</p>'. 
                                  '<p>People who are genuinely interested to try the offer and who become "hooked" after watching your videos or live streams. Involve your audience, challenge them, help them discover what is awesome and addictive and why you love it!</p>'.
                                  '<p>Bottom line: Create compelling content that is going to make viewers want the product, and keep wanting it every day.</p>',
                       'sortOrder'=>5,
                       'categories'=>array('Marketing')
                       );
        
        $faq[] = array('question'=>'How do I get more conversions?',
                       'answer'=>'<p>Conversions typically depend on a lot of factors, such as country, ad-blockers, and if the person who clicks has already registered an account on the game before.</p>'.
                                  '<p>It is all about who your clicks are coming from. We see some partners get anywhere from 10%-75% conversion rates.  If you could get the majority of people that click to sign up (say 50% of clicks), then that would be a great conversion rate.</p>'.
                                  '<p>Conversions are important, but do not focus too much on them. Just make compelling content that is going to make viewers want to play the game.</p>'.
                                  '<p><b>Bottom line:</b> If you focus more on making the games look appealing and keep creating great content, the conversions will come naturally.</p>',
                       'sortOrder'=>6,
                       'categories'=>array('Marketing')
                       );
        
        $faq[] = array('question'=>'Can I do PPC or PPV traffic? - Only if ...',
                       'answer'=>'<p>As we say in our Terms & Conditions at <a href="http://www.any.tv/terms" target="_blank">www.any.tv/terms</a> the #1 Main Rule is: You must use relevant videos or live streams to promote our Play Now links.</p>'.
                                  '<p>Also, you cannot use incentivized traffic, such as giveaways where one of the steps is to click our Play Now links.</p>'.
                                  '<p>So, you can do PPC or PPV traffic only if you use video next to our Play Now links and it is not incentivized.</p>'. 
                                  '<p>For example, here is a great forum post: <a href="http://my.mmosite.com/3031804/blog/item/scarlet_blade_open_beta_first_look.html" target="_blank">my.mmosite.com/3031804/blog/item/scarlet_blade_open_beta_first_look.html</a></p>'.
                                  '<p>And here is a great video on YouTube: <a href="http://www.youtube.com/watch?v=5BDA3iyP9S8&list=PLyI74zGGymu9iDHGD5izu0ZxS33NsU5_2" target="_blank">www.youtube.com/watch?v=5BDA3iyP9S8&list=PLyI74zGGymu9iDHGD5izu0ZxS33NsU5_2</a></p>',
                       'sortOrder'=>7,
                       'categories'=>array('Marketing')
                       );
        
        $faq[] = array('question'=>'I have a popular video, can I put any Play Now links beneath it? - Yes, but ...',
                       'answer'=>'<p>You can add any relevant Play Now link beneath your video.</p>'.
                                  '<p>For example, if you made a video about League of Legends, use the League of Legends Play Now link. Or, use a Play Now link from another MOBA, like Smashmuck Champions or Dota 2.</p>'.
                                  '<p>Several game publishers complained to us about low-quality conversions which happens if people don\'t know what to expect after clicking a Play Now link.</p>'. 
                                  '<p>It is not good to just get conversions. Game publishers want conversions from people genuinely interested to play their games!</p>'.
                                  '<p>Ultimately, the publishers tell us which of our partners are driving good quality traffic, and which are driving bad quality. If any partner drives only bad quality traffic, we have to block their account to maintain our good reputation with publishers.</p>'.
                                  '<p>Bottom line: Do not add random Play Now links beneath your videos!</p>'.
                                  '<p>For example, do not add a League of Legends Play Now link beneath a video about The Walking Dead or a video about cats.</p>',
                       'sortOrder'=>8,
                       'categories'=>array('Marketing')
                       );
        
        $faq[] = array('question'=>'Can I put unrelated Play Now links beneath my videos?',
                       'answer'=>'<p>Yes!</p>'.
                                  '<p>You can put any Play Now links you like beneath your videos, but we encourage you to put Play Now links related to the game. Why? You will get more clicks from people who like the game in the video :-)</p>'.
                                  '<p>And tell people about the Play Now links. Say in your videos: "If you like this game, click the link below to play it!" and you will get even more clicks and conversions.</p>'. 
                                  '<p>Hope this helps!</p>',
                       'sortOrder'=>9,
                       'categories'=>array('Marketing')
                       );
        
        $faq[] = array('question'=>'Can I do giveaways using Play Now links?',
                       'answer'=>'<p>We do not allow incentivized clicks, like "Sign up at this Play Now link to enter our giveaway".</p>'.
                                  '<p>Game publishers pay for people with a real interest to play their game!</p>'.
                                  '<p>Create a giveaway by challenging your audience to reach level 20 to enter your contest!</p>'. 
                                  '<p>Create videos or game reviews to get people excited to try the game.</p>'.
                                  '<p>Basically, anything that directly talks about the game is encouraged.</p>',
                       'sortOrder'=>10,
                       'categories'=>array('Marketing')
                       );
        
        // partnership
        
        $faq[] = array('question'=>'Two partnerships at the same time - how is that possible?',
                       'answer'=>'<p>Can you add Amazon "Buy Now" links into your video descriptions and be partnered by a Network?</p>'.
                                  '<p>Of course you can!</p>'.
                                  '<p>Think of any.TV like Amazon.com, but instead of "Buy Now" links, we give you "Play Now" links.</p>'.
                                  '<p>You will earn <b>both</b> YouTube ad revenue and any.TV recommendation revenue at the same time!</p>',
                       'sortOrder'=>1,
                       'categories'=>array('Partnership')
                       );
        
        $faq[] = array('question'=>'Can I get the YouTube banner?',
                       'answer'=>'<p>Actually, everybody gets YouTube banners now!</p>'.
                                  '<p>All you need to do is enable the new YouTube One Channel layout.</p>'.
                                  '<p>See <a href="http://www.youtube.com/onechannel" target="_blank">www.youtube.com/onechannel</a></p>'. 
                                  '<p>For example, the official any.TV YouTube channel is not partnered with YouTube or a YouTube Network, and we have a banner :-)</p>'.
                                  '<p>See <a href="http://www.youtube.com/anyTVnetwork" target="_blank">www.youtube.com/anyTVnetwork</a></p>',
                       'sortOrder'=>2,
                       'categories'=>array('Partnership')
                       );
        
        // payments
        
        $faq[] = array('question'=>'Will any.TV pay me? - Yes, every 30 days, if ...',
                       'answer'=>'<p>If you follow our Terms & Conditions, any.TV pays you every 30 days by PayPal.</p>'.
                                  '<ul>'.
                                  '<li>May ➜ Jul (May earnings are paid in July)</li>'.
                                  '<li>Jun ➜ Aug</li>'.
                                  '<li>Jul ➜ Sep</li>'.
                                  '</ul>'.
                                  '<p>If you do not follow our Terms & Conditions, your account may get blocked.</p>'.
                                  '<p>See <a href="http://www.any.tv/terms" target="_blank">www.any.tv/terms</a></p>',
                       'sortOrder'=>1,
                       'categories'=>array('Payments')
                       );
        
        $faq[] = array('question'=>'Can I just earn Refer-a-Friend revenue? - Yes, but only if ...',
                       'answer'=>'<p>You will get paid Refer-a-Friend revenue only if you get at least one Play Now link conversion.</p>'.
                                  '<p>Why?</p>'.
                                  '<p>We want our partners to use the dashboard, not just promote it to others. This is called "eating your own steak" :-)</p>'. 
                                  '<p>The easiest way to get a conversion is to make a video about any offer that interests you from <a href="http://www.any.tv/dashboard" target="_blank">www.any.tv/dashboard</a> by clicking your own Play Now link. As long as you promote the offer, it is okay to click your own link.</p>'.
                                  '<p>Note: If you do not get a conversion one month, your Refer-a-Friend revenue carries over to the next month and will be paid out as soon as you have a month with at least one conversion.</p>',
                       'sortOrder'=>2,
                       'categories'=>array('Payments')
                       );
        
        $faq[] = array('question'=>'Am I guaranteed to get paid what the dashboard reports as my earnings?',
                       'answer'=>'<p>Yes, if you did not do anything bad, like use bots or misdirect people to click your Play Now links to get something else, like entry into a contest.</p>'.
                                  '<p>We pay for legitimate leads where you promote the game honestly and the people who click your link genuinely want to try the game.</p>',
                       'sortOrder'=>3,
                       'categories'=>array('Payments')
                       );
        
        $faq[] = array('question'=>'Why is there a two month payout delay?',
                       'answer'=>'<p>As with YouTube, it takes a full month after the end of each month for publishers to weed out the fraudulent conversions made by bots and spammers.</p>'.
                                  '<p>Hopefully this audit can take less time in the future.</p>'.
                                  '<p>Don\'t worry, as soon as any.TV gets paid, you get paid!</p>',
                       'sortOrder'=>4,
                       'categories'=>array('Payments')
                       );
        
        $faq[] = array('question'=>'What does $11 CPM mean?',
                       'answer'=>'<p>$11 CPM means, on average, any.TV partners earn $11 per thousand views by using Play Now links from our dashboard in their YouTube videos and Twitch live streams.</p>'.
                                  '<p>For some real example, see "Featured any.TV Partners" on <a href="http://www.any.tv">www.any.tv</a></p>',
                       'sortOrder'=>5,
                       'categories'=>array('Payments')
                       );
        
        $faq[] = array('question'=>'So you will pay me $11 CPM for all my videos?',
                       'answer'=>'<p>No, we pay you about $1.00 per gamer.</p>'.
                                  '<p>We found that, on average, if you make good videos that get people excited to play the game, this $1.00 payout is the same as $11 CPM.</p>'.
                                  '<p>How do you calculate your CPM? Divide your earnings by your video views that have Play Now links.</p>'. 
                                  '<p>For some real-life CPM examples, see "Featured any.TV partners" on our website: <a href="http://www.any.tv">www.any.tv</a></p>',
                       'sortOrder'=>6,
                       'categories'=>array('Payments')
                       );
        
        /*
        $faq[] = array('question'=>'Why does my billing page show $0, but the dashboard says I made $33?',
                       'answer'=>'<p>The dashboard shows all your earnings updated every minute that will be paid to you monthly.</p>'.
                                  '<p>The billing page shows when you get paid with a detailed breakdown.</p>'.
                                  '<p>If your billing page shows $0, it just means you have not been paid yet, but you will be :-)</p>',
                       'sortOrder'=>7,
                       'categories'=>array('Payments')
                       );
         */
        
        $faq[] = array('question'=>'Are there any taxes involved in any.TV?',
                       'answer'=>'<p>There are no taxes involved in any.TV﻿</p>'.
                                  '<p>We pay you by PayPal and it is up to you to declare your income.</p>',
                       'sortOrder'=>8,
                       'categories'=>array('Payments')
                       );
        
        $faq[] = array('question'=>'Is there a minimum payout?',
                       'answer'=>'<p>There are no minimum payouts.</p>'.
                                  '<p>If you make $1 you get paid $1 :-)</p>',
                       'sortOrder'=>9,
                       'categories'=>array('Payments')
                       );
        
        $faq[] = array('question'=>'How many clicks will make me $10?',
                       'answer'=>'<p>About 100 clicks will make you $10.</p>'.
                                  '<p>On average, we have seen 6 clicks get 1 conversion on videos that get your audience excited to play the game.</p>'.
                                  '<p>Many games pay $1.00 per conversion, others pay $0.60, and a few pay more than $1.00 and a few less than $0.60.</p>'. 
                                  '<p>It also depends on which country the conversion comes from. Higher-paying countries include USA, Canada, UK, Australia, Germany, Austria and Switzerland. Lower-paying countries include Turkey, Philippines, Poland and India.</p>',
                       'sortOrder'=>10,
                       'categories'=>array('Payments')
                       );
        
        $faq[] = array('question'=>'I got over 170 clicks but I am not making any money - why not?',
                       'answer'=>'<p>You get paid whenever someone creates an account and starts playing the game after clicking your Play Now link.</p>'.
                                  '<p>Try making a video targeted at gamers who have not tried the game yet, and give them exciting reasons to try playing it!</p>',
                       'sortOrder'=>11,
                       'categories'=>array('Payments')
                       );
        
        foreach($faq as $faq_element)
        {
          $faq_item = new Faq();
          $faq_item->setQuestion($faq_element['question']);
          $faq_item->setAnswer($faq_element['answer']);
          $faq_item->setSortOrder($faq_element['sortOrder']);
          
          foreach($faq_element['categories'] as $category)
          {
            if($this->hasReference('faq_category_'.$category))
            {
              $faq_item->addCategorie($this->getReference('faq_category_'.$category)); 
            }    
          }
          
          $manager->persist($faq_item);
        }

        $manager->flush();
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 52; // the order in which fixtures will be loaded
    }
}
