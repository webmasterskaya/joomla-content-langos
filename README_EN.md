[Читать на русском](https://github.com/webmasterskaya/joomla-content-langos/blob/master/README.md)

# Insert language constants into Joomla! Content

A content plugin for inserting language constant values, for example, in an article. The syntax is `{langos LANGUAGE_CONSTANT}`.

### Idea
😎 When you build a multilingual site on Joomla, you are faced with a dilemma - a module or material, in different languages, differs with just a couple of words. Do not create a separate module for this!

👍 This plugin solves the problem! Create language constants and paste them into a module or material using the short tag `{langos LANGUAGE_CONSTANT}`.

🙌 It's simple - the plugin performs functions similar to the `echo JText :: _ ('LANGUAGE_CONSTANT')`, only you need to program nothing in this case 😉

### Installation

1. Download the latest version of the plugin from the developer's site https://webmasterskaya.xyz/products/joomla/plaginy/joomla-content-langos
2. Go to the control panel of your site 👉 Extensions 👉 Extension Manager 👉 Installation
3. Download the plugin through the form in the control panel and wait for the installation to complete
4. Follow the link provided in the message about the successful installation and activate the plugin

### Application

1. Go to your site’s control panel 👉 Extensions 👉 Languages ​​👉 Overriding constants
2. Choose the language of the site for which you want to create a constant
3. Click "Create" and fill in the required fields - `Language constant *` and `Text` (if something is not clear - hover over the name of the field to get a hint)
4. Save the constant and do the same operations for the second language (if necessary)
5. Go to editing the page or module where you wanted to insert a constant
6. In the text editor, paste the code `{langos LANGUAGE_CONSTANT}` _ (!!! LANGUAGE_CONSTANT should be replaced with the name of the language constant that you created in step # 3) _

For the plugin to work correctly in a module such as HTML, do not forget to enable the option "Processing by plugins" on the tab "Basic parameters", on the module editing page.

### Thank 💰

If you want to get more free extensions - toss a "coin" to the developer on coffee☕ and cookies🍪: https://webmasterskaya.xyz/donate