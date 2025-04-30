# Insert Language Constants into Joomla Content

[Читать на Русском](README.md)

This plugin allows you to insert language constant values into articles, modules, and other Joomla content using the `{langos LANGUAGE_CONSTANT}` syntax.

---

### ⚠️ Problem

When building a multilingual site in Joomla, you might often face this issue:

> You only need to change a few words in a module or article depending on the language — but you end up creating separate versions of the same content for each language.  
This is inefficient and time-consuming.

---

### ✅ Solution

**LangOS** lets you insert language constants directly into your content using a simple tag-like syntax:

```
{langos YOUR_LANGUAGE_CONSTANT}
```

It works just like `\Joomla\CMS\Language\Text::_('YOUR_LANGUAGE_CONSTANT')` in PHP code, but **without any programming or template editing required**.

Additionally, the plugin supports loading language constants from specific extensions (like modules or components). Just provide a **third argument** in the shortcode:

```
{langos MOD_FOOTER_LINE1, mod_footer}
```

LangOS will now load the correct value from the language file of that specific extension.

---

### 💡 Key Features

- 🧩 Insert language constants into any content: articles, modules, etc.
- 🌐 Fully integrated with Joomla's multilingual system
- 🔌 Works out of the box with standard content types
- 🛠 No programming skills required
- 🧪 Safe for visual editors and non-developers
- 📦 Supports loading language files from specific extensions
- 🎯 Perfect for dynamic text replacement across languages

---

### ⚙️ Requirements

- Joomla >= 4.2 | 5.x
- PHP >= 7.4

---

### 📦 Installation

1. Download the latest version from the developer site:  
   [https://webmasterskaya.xyz/products/joomla/plaginy/joomla-content-langos](https://webmasterskaya.xyz/products/joomla/plaginy/joomla-content-langos)
2. Go to your Joomla Admin → Extensions → Manage → Install
3. Upload and install the `.zip` file
4. After installation, enable the plugin via:  
   Extensions → Plugins → Find "LangOS" and activate it

---

### 🛠 How to Use

#### 1. Inserting a Simple Language Constant

1. Go to:  
   Extensions → Languages → Overrides
2. Select the desired language
3. Click **New**, then fill in:
   - **Language Constant** (e.g., `COM_MY_CUSTOM_TEXT`)
   - **Text** (the actual value to display)
4. Save and repeat for other languages if needed
5. Open an article or module where you want to use the constant
6. Insert the tag:  
   ```text
   {langos COM_MY_CUSTOM_TEXT}
   ```

#### 2. Load Constant from an Extension's Language File

If the constant belongs to a specific extension (e.g., a module), pass the extension name as the third argument:

```text
{langos MOD_FOOTER_LINE1, mod_footer}
```

The plugin will automatically load the correct value from the extension’s language file.

> **Note**  
> For HTML modules: Make sure to enable **Process Plugins** under the *Basic Options* tab when editing the module.

---

### 📄 License

This plugin is distributed under the **[GNU General Public License v3.0](LICENSE)**.