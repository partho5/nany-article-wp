# Nany Article WP – SEO Meta for REST API  

**Nany Article WP** is a simple WordPress plugin that lets you get **Yoast SEO, Rank Math, and custom meta fields** using the **WordPress REST API**.  

This plugin works with 🔗 **[Nany Article](https://arti.nanybot.com/go/NW6)** – an AI-powered tool that writes **expert-level SEO articles in minutes**.  

💡 **Why is this useful?**  
- If you use **Nany Article**, this plugin **lets it auto-publish** content on your site.  
- It also **enables Application Passwords**, which are needed for REST API access.  
- Your **Yoast and Rank Math SEO data** will be available in API responses.  

## 🚀 What This Plugin Does  
- **Adds SEO data** (Yoast & Rank Math) to REST API responses.  
- **Lets AI tools post on your site** (if REST API is enabled).  
- **Works for headless WordPress, automation, and SEO tools.**  

## 🔧 How to Install  
1. **Download & install** the plugin in WordPress.  
2. **Activate** it from the WordPress plugins menu.  
3. **Enable REST API & Application Passwords** (needed for AI tools).  
4. **Use the API** to get SEO meta data.  

## 📌 How to Use the API  
Once the plugin is active, you can **get SEO meta data** for any post. You have to have Yoast or RankMath plugin installed & activated first.  


👉 Example API Requests:  

### 🔍 Get SEO Meta Data (Yoast & Rank Math)  
```bash
GET {wordpress-installed-URL}/wp-json/wp/v2/posts/{id}
```
**Response:**  
```json
{
  "id": 123,
  "title": "Sample Post",
  "yoast_meta": {
    "yoast_wpseo_focuskw": "Focus Keyword",
    "yoast_wpseo_metadesc": "SEO Meta Description"
  },
  "rank_math_meta": {
    "rank_math_focus_keyword": "Focus Keyword",
    "rank_math_description": "SEO Meta Description"
  }
}
```

### ✍️ Set SEO Meta Data (Yoast & Rank Math)  
```bash
POST {wordpress-installed-URL}/wp-json/wp/v2/posts/{id}
```
**Headers:**  
```json
{
  "Authorization": "Basic YOUR_ENCODED_CREDENTIALS",
  "Content-Type": "application/json"
}
```
**Body:**  
```json
{
  "title": "Your Article Title",
  "content": "This is the body of your WordPress post.",
  "status": "publish",
  
  "yoast_meta": {
    "yoast_wpseo_focuskw": "New Focus Keyword",
    "yoast_wpseo_metadesc": "New SEO Description"
  },
  
  "rank_math_meta": {
    "rank_math_focus_keyword": "New Focus Keyword",
    "rank_math_description": "New SEO Description"
  }
}

```


## 🔗 Works Best With Nany Article  
If you use **[Nany Article](https://arti.nanybot.com/go/NW6)**, this plugin lets it **auto-publish** AI-generated content directly to your WordPress site!  

This plugin is a fork of [DevinVinson/WordPress-Plugin-Boilerplate](https://github.com/DevinVinson/WordPress-Plugin-Boilerplate).  