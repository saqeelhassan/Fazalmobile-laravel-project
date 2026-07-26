<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $posts = [
            [
                'title'   => 'How to Choose the Right Smart Watch in 2026: A Complete Buying Guide',
                'category' => 'Smart Watches',
                'excerpt' => 'Battery life, health tracking, display type, and compatibility — here\'s exactly what to check before buying a smart watch in Pakistan.',
                'meta_description' => 'A practical 2026 smart watch buying guide: battery life, health sensors, display, compatibility and budget tips for shoppers in Pakistan.',
                'body' => <<<'HTML'
<p>Smart watches have gone from a niche gadget to an everyday essential, but with dozens of models on the market it's easy to end up with the wrong one. This guide breaks down exactly what matters so you can buy with confidence.</p>

<h2>1. Battery Life Matters More Than Specs</h2>
<p>Most people are surprised by how much battery life varies between models — anywhere from a day and a half to two full weeks. If you plan to use sleep tracking, look for a watch rated for at least 5–7 days per charge, otherwise you'll end up charging it overnight and losing sleep data.</p>

<h2>2. Health & Fitness Tracking</h2>
<p>Almost every smart watch now tracks steps and heart rate, but the useful extras — SpO2 (blood oxygen), stress tracking, and multi-sport modes — vary a lot by price tier. If fitness is your main reason for buying, prioritize a model with continuous heart-rate monitoring and GPS.</p>

<h2>3. Display Type: AMOLED vs LCD</h2>
<p>An AMOLED display gives you deeper blacks, better outdoor visibility, and an "always-on" option, at the cost of slightly shorter battery life. For daily wear and readability in sunlight, AMOLED is worth the small premium.</p>

<h2>4. Compatibility With Your Phone</h2>
<p>Before buying, confirm the watch's companion app supports your phone's operating system properly — some budget watches have limited iPhone functionality (no reply-to-message, limited notifications). Check this first if you're on iOS.</p>

<h2>5. Strap Comfort and Build Quality</h2>
<p>You'll be wearing this every day, so a comfortable, swappable strap and a scratch-resistant screen coating matter more than most buyers expect. Look for at least IP68 water resistance so sweat and rain aren't a concern.</p>

<h2>Our Recommendation</h2>
<p>Browse our current <a href="/shop?category=Smart%20Watches">Smart Watches collection</a> — every model listed includes battery life, display type, and water-resistance rating in the product description so you can compare at a glance.</p>
HTML,
            ],
            [
                'title'   => 'Wired vs Wireless Gaming Controllers: Which Should You Buy?',
                'category' => 'Games',
                'excerpt' => 'Latency, battery anxiety, and comfort — we compare wired and wireless gaming controllers so you can pick the right one for your setup.',
                'meta_description' => 'Wired vs wireless gaming controllers compared: input latency, battery life, comfort and price — find out which is right for your gaming setup.',
                'body' => <<<'HTML'
<p>The wired-vs-wireless debate comes up every time someone shops for a new controller. The honest answer is: it depends on how and where you play. Here's the breakdown.</p>

<h2>Input Latency</h2>
<p>Modern wireless controllers using 2.4GHz dongles or Bluetooth 5.0+ have closed the latency gap significantly — for casual and even most competitive play, the difference is no longer noticeable to most players. Wired still holds a very slight edge for professional esports setups, but it's marginal today.</p>

<h2>Battery Life and Convenience</h2>
<p>The real trade-off is convenience. Wireless controllers free you from cable clutter and let you play from the couch, but you do need to charge them — look for controllers rated for 20+ hours per charge, and ideally ones that support play-while-charging via USB-C.</p>

<h2>Comfort for Long Sessions</h2>
<p>Grip texture, trigger travel, and weight distribution affect comfort more than connection type. If you play for multiple hours at a time, prioritize a controller with textured grips and adjustable trigger sensitivity.</p>

<h2>Which Should You Choose?</h2>
<ul>
<li><strong>Choose wired</strong> if you game exclusively at a desk, want zero setup, and don't mind the cable.</li>
<li><strong>Choose wireless</strong> if you play from a couch, switch between devices often, or simply want a cleaner setup.</li>
</ul>

<p>Check out our <a href="/shop?category=Games">gaming controllers and accessories</a> for both wired and wireless options with detailed battery and compatibility specs.</p>
HTML,
            ],
            [
                'title'   => 'True Wireless Airbuds: Sound Quality vs Battery Life Explained',
                'category' => 'Airbuds',
                'excerpt' => 'Not all airbuds are built the same. Here\'s how to weigh sound quality, ANC, and battery life so you don\'t regret your purchase.',
                'meta_description' => 'Learn how sound quality, active noise cancellation, and battery life trade off in true wireless airbuds, and how to pick the right pair for your needs.',
                'body' => <<<'HTML'
<p>Airbuds are one of the most personal tech purchases you'll make — what sounds great to one person can feel flat to another. Still, there are objective factors worth understanding before you buy.</p>

<h2>Driver Size and Sound Signature</h2>
<p>Larger drivers generally produce richer bass, but tuning matters more than raw size. If you listen to a lot of vocals or podcasts, look for a balanced or "vocal-forward" tuning rather than a bass-heavy one.</p>

<h2>Active Noise Cancellation (ANC)</h2>
<p>ANC is fantastic for commutes and flights, but it does drain battery faster and can occasionally introduce a faint hiss on lower-end chipsets. If you mostly listen at home or in a quiet office, you can save money by skipping ANC entirely.</p>

<h2>Battery Life: Buds vs Case</h2>
<p>Always check both numbers — battery life <em>per charge</em> in the buds themselves (typically 4–8 hours) and <em>total</em> life including the charging case (usually 20–30 hours). If you travel often, total case life matters more than per-charge life.</p>

<h2>Fit and Seal</h2>
<p>A good ear-tip seal affects both comfort and perceived bass response more than almost any other spec. Buds that come with multiple ear-tip sizes are worth prioritizing, especially if you've struggled with buds falling out before.</p>

<h2>Our Pick Criteria</h2>
<p>Explore our <a href="/shop?category=Airbuds">airbuds collection</a> — each listing includes battery life (buds + case), ANC availability, and water-resistance rating.</p>
HTML,
            ],
            [
                'title'   => 'USB-C vs Lightning vs Micro-USB: A Simple Guide to Charging Cables',
                'category' => 'Cables',
                'excerpt' => 'Confused by cable types and charging speeds? Here\'s a plain-English explainer on USB-C, Lightning, and Micro-USB.',
                'meta_description' => 'A simple explainer on USB-C, Lightning, and Micro-USB cables — charging speeds, durability, and which cable your device actually needs.',
                'body' => <<<'HTML'
<p>Cables seem simple until you're standing in front of a wall of near-identical options. Here's what actually differs between them.</p>

<h2>USB-C: The New Standard</h2>
<p>USB-C is now used by most Android phones, tablets, laptops, and even newer iPhones. It's reversible (no more flipping it three times to plug in), and supports much faster charging speeds when paired with a compatible fast charger — often 30W to 100W+ depending on the cable and charger rating.</p>

<h2>Lightning: Older Apple Devices</h2>
<p>Lightning cables are still required for older iPhone and iPad models. If you're buying a replacement cable, check the charging wattage rating — cheap uncertified cables often cap charging speed well below what your charger can actually deliver.</p>

<h2>Micro-USB: Legacy but Still Common</h2>
<p>You'll still find Micro-USB on some budget accessories, power banks, and older devices. It's the slowest of the three and doesn't support fast-charging standards well, but remains cheap and widely available.</p>

<h2>Does Cable Quality Actually Matter?</h2>
<p>Yes — a poorly made cable with thin internal wiring will bottleneck your charging speed regardless of how powerful your charger is, and can wear out (fraying, intermittent connection) within months. Braided cables with reinforced connectors last significantly longer under daily use.</p>

<h2>Shop by Connector Type</h2>
<p>Browse our <a href="/shop?category=Cables">cables and connectors</a> to find the right type and length for your charger and device.</p>
HTML,
            ],
            [
                'title'   => 'Mini Projectors for Home Cinema: What Resolution and Lumens Actually Mean',
                'category' => 'Projector',
                'excerpt' => 'Lumens, resolution, and throw distance explained simply — so you can set up a great home cinema without overspending.',
                'meta_description' => 'Understand projector lumens, resolution, and throw distance so you can choose the right mini projector for movie nights at home.',
                'body' => <<<'HTML'
<p>Mini projectors have become a genuinely great way to build a home cinema setup without spending a fortune on a large TV. Here's how to read the spec sheet correctly.</p>

<h2>Lumens: Brightness for Your Room</h2>
<p>Lumens measure how bright the projected image is. For a dark room at night, 1,500–2,000 lumens is plenty. If you plan to use it with some ambient light on, look for 3,000+ lumens so the picture doesn't wash out.</p>

<h2>Resolution: Native vs Supported</h2>
<p>Pay close attention to "native resolution" versus "supported resolution." A projector might say it "supports 4K," but its native resolution (the actual pixels on the imaging chip) could be 720p or 1080p — meaning it downscales 4K input rather than displaying true 4K detail. For sharp text and fine detail, native 1080p is the practical sweet spot for most home setups.</p>

<h2>Throw Distance</h2>
<p>This determines how far the projector needs to sit from the wall or screen to produce a given image size. Short-throw projectors are great for small rooms since they can produce a large image from close range.</p>

<h2>Built-In Speakers vs External Audio</h2>
<p>Most mini projectors have small built-in speakers that are fine for casual viewing but underwhelming for movies. Pairing with a soundbar or Bluetooth speaker makes a noticeable difference for home cinema use.</p>

<h2>Find the Right Fit</h2>
<p>Check our <a href="/shop?category=Projector">projector lineup</a> for lumens, native resolution, and throw-distance details on every model.</p>
HTML,
            ],
            [
                'title'   => 'Fast Charger Buying Guide: Watts, Ports, and What "Fast Charging" Really Means',
                'category' => 'Charger',
                'excerpt' => 'Not all fast chargers are equal. Here\'s how wattage and charging protocols actually affect how quickly your phone charges.',
                'meta_description' => 'A practical guide to charger wattage, USB Power Delivery, and Quick Charge protocols — pick a fast charger that actually matches your device.',
                'body' => <<<'HTML'
<p>"Fast charging" gets printed on almost every charger box, but the actual speed you get depends on more than just the label. Here's what determines real-world charging speed.</p>

<h2>Wattage: The Core Number</h2>
<p>Most modern phones charge fastest somewhere between 18W and 45W, while tablets and laptops may need 65W–100W. Buying a charger rated higher than your device needs isn't wasteful — most devices will simply draw only what they need — but buying one rated lower will noticeably slow down your charging.</p>

<h2>Charging Protocols: PD vs Quick Charge</h2>
<p>USB Power Delivery (PD) and Qualcomm Quick Charge are the two most common fast-charging standards. Your charger and cable both need to support the same protocol as your phone for fast charging to actually kick in — mismatched combinations silently fall back to slow charging with no error message.</p>

<h2>Single-Port vs Multi-Port Chargers</h2>
<p>Multi-port GaN (Gallium Nitride) chargers can charge two or more devices at once, but total wattage is shared across ports — check the per-port wattage, not just the total, if you plan to charge a phone and a laptop simultaneously.</p>

<h2>Why the Cable Matters Too</h2>
<p>A fast charger paired with a low-quality or old cable will still charge slowly. For full-speed charging, use a cable rated for the same wattage as your charger.</p>

<h2>Shop Chargers</h2>
<p>Browse our <a href="/shop?category=Charger">chargers</a> filtered by wattage and port type to find the right match for your devices.</p>
HTML,
            ],
            [
                'title'   => 'Do You Really Need a Phone Cooling Fan? Here\'s When It Actually Helps',
                'category' => 'Cooling Fan',
                'excerpt' => 'Mobile cooling fans aren\'t just for gamers. Here\'s when a clip-on cooling fan makes a real difference to performance and battery health.',
                'meta_description' => 'Find out when a phone cooling fan actually improves gaming performance and battery health, and what to look for before buying one.',
                'body' => <<<'HTML'
<p>Clip-on phone cooling fans look like a gimmick at first glance, but for certain use cases they solve a real problem: thermal throttling.</p>

<h2>What Is Thermal Throttling?</h2>
<p>When a phone's processor gets too hot during intensive tasks — heavy gaming, long video calls, or navigation with the screen at full brightness — it automatically slows itself down to avoid damage. This is called thermal throttling, and it directly causes frame drops and lag in games.</p>

<h2>Who Actually Benefits</h2>
<ul>
<li><strong>Mobile gamers</strong> playing graphically demanding titles for 30+ minutes at a stretch</li>
<li><strong>Streamers</strong> recording gameplay while the phone also has to encode video</li>
<li><strong>Anyone in hot climates</strong> where ambient temperature already pushes the phone closer to its thermal limit</li>
</ul>
<p>If you mostly browse, message, and watch the occasional video, a cooling fan won't make a noticeable difference — your phone rarely hits throttling temperatures during light use.</p>

<h2>Semiconductor Cooling vs Simple Fans</h2>
<p>Basic clip-on fans work by blowing air across the back of the phone. More advanced models add a semiconductor (Peltier) cooling plate that actively lowers the temperature below ambient — these cool faster but use more power and are usually a bit bulkier.</p>

<h2>Does It Affect Battery Health?</h2>
<p>Indirectly, yes — heat is one of the biggest long-term factors in battery degradation. Keeping your phone cooler during heavy use can help preserve battery capacity over the phone's lifespan, not just improve performance in the moment.</p>

<h2>Shop Cooling Fans</h2>
<p>See our <a href="/shop?category=Cooling%20Fan">mobile cooling fans</a> lineup, including semiconductor and standard fan options.</p>
HTML,
            ],
            [
                'title'   => '5 Signs It\'s Time to Upgrade Your Phone Accessories',
                'category' => 'Buying Guides',
                'excerpt' => 'Frayed cables, dying earbuds, slow chargers — here are five clear signs your current accessories are due for a replacement.',
                'meta_description' => 'Five practical signs that your phone accessories — cables, chargers, earbuds — need replacing, plus what to upgrade to.',
                'body' => <<<'HTML'
<p>Phone accessories wear out quietly — there's rarely one dramatic failure, just a slow decline until you're annoyed every single day. Here are five signs it's time to replace yours.</p>

<h2>1. Your Cable Only Works at "The Right Angle"</h2>
<p>If you find yourself holding the cable at a specific angle for it to charge, the internal wiring near the connector has likely frayed. This is also a minor safety concern — keep using it and it can eventually stop charging entirely, or in rare cases overheat.</p>

<h2>2. Charging Takes Noticeably Longer Than It Used To</h2>
<p>Batteries in chargers and power banks degrade over time, and cheap cables can develop resistance internally. If a charge that used to take an hour now takes two, it's worth testing with a known-good cable and charger before assuming it's your phone's battery.</p>

<h2>3. One Earbud Is Quieter Than the Other</h2>
<p>This is one of the most common airbuds failure patterns — a slightly quieter or crackling earbud usually means the driver or battery cell is degrading, and it typically continues to worsen rather than fix itself.</p>

<h2>4. Your Power Bank Doesn't Hold a Full Charge</h2>
<p>If your power bank used to charge your phone twice and now barely manages once, its internal battery cells have lost capacity — a completely normal effect of repeated charge cycles over a year or two of use.</p>

<h2>5. You're Missing Features Your Devices Now Support</h2>
<p>If you've upgraded your phone but kept an old charger or cable, you might be missing out on faster charging speeds or higher-quality audio your new device actually supports.</p>

<h2>Ready to Upgrade?</h2>
<p>Browse our full <a href="/shop">accessories catalog</a> — smart watches, airbuds, cables, chargers, cooling fans and more, all in one place.</p>
HTML,
            ],
        ];

        $daysAgo = count($posts);
        foreach ($posts as $index => $data) {
            $slug = Str::slug($data['title']);
            BlogPost::updateOrCreate(
                ['slug' => $slug],
                [
                    'title'             => $data['title'],
                    'meta_title'        => $data['title'] . ' | Fazal Mobile Blog',
                    'meta_description'  => $data['meta_description'],
                    'excerpt'           => $data['excerpt'],
                    'body'              => $data['body'],
                    'category'          => $data['category'],
                    'author_name'       => 'Fazal Mobile Team',
                    'status'            => 'active',
                    'is_featured'       => $index < 2,
                    'views'             => random_int(40, 900),
                    'published_at'      => now()->subDays($daysAgo - $index),
                ]
            );
        }
    }
}
