=== Postmatic ===
Contributors: Postmatic
Tags: email, notification, notify, posts, subscribe, subscription, email, subscribe to comments, commenting, reply, email, optins, popups, optin forms, opt-in, subscribe form, comments, posts, reply, subscribe, mail, listserve, mailing, subscriptions, newsletter, newsletters, email newsletter, email subscription, newsletter signup, post notification, newsletter alert, auto newsletter, automatic post notification, email newsletters, email signup, auto post notifications, subscribe widget, signup widget, email subscription, newsletter plugin, widget, subscription, emailing, mandrill, mailchimp, mailgun, email commenting, reply to email, email replies, engagement, invite, invitations
Requires at least: 4.3
Tested up to: 4.7
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Postmatic lets your readers subscribe to comments or posts by email. And comment by simply hitting reply. From wherever they are.

== Description ==

Postmatic for WordPress. This plugin enables premium Postmatic features.


== Changelog ==

= 2.0.10 =
- FIXED: Changes made to digests were not sticking in some cases.
- FIXED: Better support for auto-detecting the site theme via https
- IMPROVED: Improved handling of 'unsubscribe' typos, including the mysterious ?unsubscribe.

= 2.0.9 =
- FIXED: We made it so you can't accidentally double click the button on the inviter and send 2x emails to everyone.
- IMPROVED: Handblebars content is now not rendered in the email version of posts.
- FIXED: If you were already subscribed to posts or digests on a site, and tried to subscribe again, sometimes a confusing confirmation email was sent. We fixed that.

= 2.0.7 =
- Updated German translation
- Misc bug fixes

= 2.0.6 =
- NEW: We added a series of video tutorials to the admin area. Look for the little play buttons.
- FIXED: Comment digests now display comments in ascending order (the latest at the bottom instead of the top).
- IMPROVED: Comment digests now include fantastic context surrounding what is new, what is old, and what was in reply to who.
- FIXED: Increased the timeout on webhooks
- TRANSLATIONS: Added updated German translation by Klaus Fromm. Thanks, Klaus!

= 2.0.4 =

- NEW: Permalinked timestamps on comment recaps.
- NEW: A tooltip on the comment form subscription checkbox gives users info about what the subscription means.
- [Added tests for better debugging of malformed inbound messages](https://github.com/postmatic/postmatic-basic/commit/1bbb721351384a2512faec50cf9ca450c2569b33)


= 2.0.3 =

- [Fixed an issue in which Postmatic caused errors on the edit>post screen of WPML users](https://github.com/postmatic/postmatic-basic/issues/5)
- Fixed errors with Freemius related to logged in users of the subscriber role
- [Simplified the admin UI to get rid of jqueryui tab conflicts](https://github.com/postmatic/postmatic-basic/pull/7)

= 2.0 RC4 =

- Ok Jason is terrible at actually freezing code. So we are sneaking in one more feature for Postmatic 2. This is the last one: Snob Mode. It's actualy comment Comment Intelilgence and it's the next step in Flood Control. In a nutshell: If you enable it via the Postmatic > Configure Comments screen it will analyze comments and determine if they are relevant enough to the conversation to bother mailing out. Heck yes. It requires [Elevated Comments](http://elevated.gopostmatic.com). Read more about it [on our blog](https://gopostmatic.com/2016/05/sneak-peak-at-postmatic-2-comment-intelligence/).
- Fixes to the new author growth widget
- Fixes to a nasty bug in the Postmatic Email Version textbox. Should be safe now.

= 2.0 RC1 =

- Fixed some bugs with the Postmatic Email Version text box
- API fix for legacy integrations (such as Caldera Forms)
- Fixed a bug in that Postmatic Precheck would still show problems even if there were none
- Fixed up some broken image paths on the Kickstarter tab in the admin interface
- Fixes for menu item layout in admin interface due to conflicts with other versions of jquery tabs
- Fixes for the author growth widget (forgot to announce that. It's on your WordPress dashboard)
- Postmatic template test emails now use the inherited styles from the theme sniffer

= 2.0 Beta 10 (0.5.0) =

- We made a bunch of improvements to [the theme sucker](https://gopostmatic.com/2016/01/sneak-peak-at-postmatic-2-smart-templates/). It will now grab font sizes as well. This is quite experimental so let us know if it's lame.
- We added a box on the Your Template screen which lets you insert custom css into your Postmatic template. Sweet.
- We have removed the BuySellAds integration in favor of an upcoming partnership.
- Added support for Custom Post Types. You'll find the setting in Configure Posts.
- Added permalink to comment moderation emails in case you like moderating from the web.
- A brand new feature: the edit>post screen now lets you completely customize the version of the post which will be sent out over email. It'll even warn you if there are troublesome shortcodes or otherwise. Essentially, this fixes the pagebuilder issue. Everyone can use Postmatic!
- Tons and tons of template tweaks, improvements, and refinements.
- Tweaks to the font sizes of the Optins
- A brand new freaking widget! It's smooth as butter. No more janky.. just soft soothing fades. The same applies to the Optins.
- We switched to sending mail using wp_mail if you are on the free plan (which you aren't if you are reading this beta-only message) instead of relying on phpmailer. 

= 2.0 Beta 9.1 (0.4.1) =

- A quick fix to the digest scheduler.

= 2.0 Beta 9 =

- AWWWWWW YEEEEAAAAAA. That's all.
- Flood Control 2 is here. If any of you are within driving distance of Reno go give Dylan a kiss. But what does it mean?! More smart email, less dumb email. Find out [on our blog](http://gopostmatic.com/2016/04/sneak-peek-at-postmatic-2-flood).
- Improved formatting of sidebar widgets in new post emails.
- This readme file! And Flood Control!


= 2.0 Beta 8 =

- More REST, less admin-ajax. This means Postmatic will use the REST API to communicate with your site when available.
- Changes to the wording of the opt-in process to try to increase conversion rates. Smarter subjects, more urgent followups.
- A ton of marketing material has been added to the free version, but you beta testers won't notice any of it.
- Lots of improvements to the new post template on the free plan.
- Added support for images to posts sent on the free plan.
- Updates to the webhooks interface. There is now a test button.
- Restored featured image support
- Better support for sidebar widgets in the email template.

= 2.0 Beta 6 =

Another huge release. Read below. As always, extra special thanks to the team here for working even harder than usual and showing incredible brilliance. Cheers to Dylan, Elissa, and Ankur. 

- New subject lines for digests. Choose to use the default (digest_name | date) or a smart subject line: (title_of_most_popular_post + X other stories from the digest_name). Thanks to the folks from @offbeatbride for the idea.
- Two new sidebars for use in your Postmatic emails: One lives above your header image at the very top of the your template (great for little announcements or ads) and one which is a sidebar floated to the right when sending single posts (great for author bios, ads, or related posts). The new floated-right sidebar is especially experimental regarding displaying a variety of widgets and keeping them looking good. Please send feedback. In general I'm still not very satisfied with how the widgets look on mobile vs desktop and am continuing to heavily tweak it. This release switches things around a bit so I can tweak their layout in realtime on our outgoing mail server without having to push another beta. Expect daily improvements as I watch what you all send out.
- Speaking of sidebars: there is a new widget and it's going to be huge. We hope.  It's the Postmatic BuySellAds widget. We've worked with buysellads.com to let you place your own ads inside your Postmatic emails. We track both clicks and impressions. It's fantastic. You'll need a valid buysellads.com account. This particular feature is extra beta so please get in touch with Jason if you'd like to try it out.
- Webhooks! You can now send Postmatic subscribe/unsubscribe events to 500+ other services via Zapier and Webhooks. Keep your Mailchimip list in sync. Make a spreadsheet of your subscribers. The sky is the limit with this one. Read all about it here: https://gopostmatic.com/2016/03/sneak-peek-at-postmatic-2-0-support-for-optinmonster-and-500-other-apps/
- OptinMonster! Postmatic now works with the hugely popular OptinMonster. I haven't had time to write documentation yet but these two screenshots should tell you what you need: https://www.evernote.com/l/AAQP3YLh9VJCHJEbsF-OIljQwfetyL9ONKk and https://www.evernote.com/l/AASiYxI2WxlLBoAmmNahNbRd98V828zRUFA
- Improvements to the email that sends welcoming a new subscriber to your site. Paragraphs now break properly and an unclosed h3 tag has been removed.
- Improvements to digests to introduce more of your theme colors to headlines and links
- The usual slew of template tweaks

There will probably be a Beta 7 released quickly after this as we're sure there are a number of tweaks needed to the new Ads system and OptinMonster... but we won't see the bugs until you start using it.

After that Beta 8 is going to focus on Flood Control 2 and small tweaks to try to improve optin conversion rates. We've done some research and there are ideas. 

= 2.0 Beta 5 =

Beta 5 is a big release. Please read this changelog carefullly.
We have split Postmatic into two plugins. The free (WordPress repo) version, and the paid version (which you have here). This follows the more traditional model for premium WordPress plugins. We tried avoiding this as long as we can but the writing is on the wall that it needs to be done. So we did. It gives us much more flexibility in our business model and most importantly lowers our development costs significantly.

Moving forward paying users will not need the version of the plugin found on the WordPress.org repository. Although it won't hurt if you happen to have it installed. So long as you have this shiny new premium version you'll be all set.

- Split core and premium plugins
- Improved layout of widgets on mobile
- Lots of template tweaks and tuning
- Improved style on embedded tweets in email
- Improvements to setting the favicon, on any theme
- The choice to send featured images on the edit post screen is now sticky again
- Digest subscription info now shows up on the users screen in WordPress
- The customized welcome email (for confirmed subscriptions) is now in place for both posts and digests

= 2.0 Beta 4 =

- Improved captions on images
- Improved spacing between headlines
- Fixed the date in the digest subject
- Digests can now be scheduled for any future date
- We remade the footer widgets areas to let you insert as many widgets as you want. They should layout appropriately. Test hard.
- Improvements to gallery formatting.
- Oh sh*t this is awesome: The comment recaps in comment notification emails are now respsonsive and mimic the same styling you'll find in Epoch. Including highlighting author responses.
- Emoji now display inline in comment emails
- Improvements to headline color styling when using theme matching
- Improvements to spacing on all digest layouts
- Fixed a bug in the Modern digest layout that was keeping stories from laying out appropriately when there was an odd number
- Support for a ton of author box plugins and putting author names in the templates. You'll need a companion plugin if you want to see that happen. A blog post about it coming later today. Get in touch if you want the plugin.


= 2.0 Beta 3 =

- There was a bug in b3 that messed up titles in newly sending posts. Fixed.

= 2.0 Beta 2 =
Mostly lots of bug fixes and adjustments to digests

- The *add to my inbox* command will now send full posts, regardless of if when you published the post you chose to send the full post or the excerpt
- Fixes for the digest chooser in firefox
- Fixes for the optins chooser in firefox
- Fixed the loader/spinner on the Send Invites screen to not be funky
- Removed link color from headlines... we now render them using the headline color
- Form elements are now stripped from emails by default

= 2.0 Beta 1 =
- Fixed an issue with switching to digest subsriptions not working if via a post excerpt. 
- Improved template for private messages to blog authors
- More template improvements including removing link color from headlines
- Fixes to digest previews to not show drafts and schedule posts
- Added mailto links for approve/trash/spam
- Updated mailpoet and mailchimp importers to support digest subscriptions

= 2.0 Alpha 4 =
- Fixed a bug in which a reply command would result in an unsubscribe in certain situations
- Added mailto links to flood control rejoin command
- Misc UI tweaks

= 2.0 Alpha 3 =
- The Traditional digest style is nicer on mobile now
- The footer notice for how to switch from digest to instant has been fixed
- Digets have a default name which is auto-generated as "Sitename Digest"

== Upgrade Notice ==

= 1.4.6 =

This version fixes a security related bug.  Upgrade immediately.

== Frequently Asked Questions ==

= This is really free? Do you sell my data or run advertising? =

Yes to free. [No to bad stuff](http://gopostmatic.com/privacy). We're not in the data brokering or advertising game. Instead we're in the business of making [Postmatic Premium](http://gopostmatic.com/premium) _so good_ and _so affordable_ that you'll happily upgrade.You can help fund our development while sending your engagement through the roof by subscribing to Postmatic Premium. We're even running [a launch special right now](http://gopostmatic.com/trial).

= Is this a 3rd party commenting system? =
Not at all. Postmatic uses native WordPress commenting. All we do is wire up some magic to turn emails into comments, then push them to your site via the WordPress api. You can [read all about](http://gopostmatic.com/technology) it here.

= How quickly do email comments post to my website =
It takes Postmatic **six to ten seconds** after you hit send to turn your email into a WordPress comment.

Find a few hundred more answers at our [big FAQ](http://gopostmatic.com/faq/).

== Screenshots ==
1. A sidebar widget lets users subscribe to all site content, or just authors they are interested in. Postmatic also integrates with 3rd party email signup plugins such as Magic Action Box.
2. New posts are sent as gorgeous mobile-ready emails. The user can just hit reply to send a comment. Nifty.
3. Comments are sent as beautiful and context-sensitive email notifications. Just reply to chime in.
4. The footer of the email invites the user to to leave a comment or manage their subscription settings. Users can subscribe to comments on this post, unsubscribe from comments on the post, or leave their own reply.
5. Followup comments are also sent using a simpler email template. They are reply-enabled as well.
6. All Postmatic emails are replyable and fully responsive.
7. The plugin registers a sidebar for configuring footer widgets to use in your email template.
8. The invitation system is fantastic. Postmatic will send invitations to an imported list or let you choose from your existing community. Users can reply to the invitation to subscribe to your site.
9. We're serious about privacy. Your data is yours, and always will be. Postmatic uses fully-native commenting. Just think of us as a magical email > WordPress gateway.
10. Postmatic is 100% compatible with all your favorite user and commenting plugins because it is fully WordPress native.
11. The popup optin can be configured based on time, page scroll, or after the user leaves a comment.
12. The after-the-post optin displays above the comment area. Shown in Dark.
13. The topbar optin shows across the top of your site on all posts and pages.
14. The bottom slider optin invites users to subscribe with a collapsible animated window.
15. The optin configuration screeen.

