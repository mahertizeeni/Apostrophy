# Laravel JWT Authentication API

هذا المشروع عبارة عن RESTful API مبني باستخدام Laravel، ويعتمد على JWT للتوثيق (Authentication) مع نظام صلاحيات Roles (Admin / User).  
جميع المسارات موثّقة بالكامل عبر Postman.

---

##  API Documentation (Postman)

تم إنشاء توثيق كامل للـ API ويمكن عرضه من الرابط التالي:

 **https://documenter.getpostman.com/view/40097079/2sB3dMyBSf**

يتضمن التوثيق:
- جميع الـ Endpoints  
- أمثلة Request / Response  
- شرح الـ Authentication باستخدام JWT  
- صلاحيات الـ Admin والـ User  
- Validation Rules  

---

##  Features

- تسجيل مستخدم جديد (Register)
- تسجيل دخول وإصدار JWT Token
- تسجيل خروج (Logout)
- جلب بيانات المستخدم الحالي (Profile)
- تحديث بيانات الحساب
- جلب جميع المستخدمين (Admin Only)
- صلاحيات Roles مبنية باستخدام Laravel Policies
- حماية المسارات باستخدام Middleware + JWTAuth

---

##  Tech Stack

- **Laravel 12**
- **PHP 8.45**
- **MySQL**
- **tymon/jwt-auth**
- **Laravel Policies**
- **Resource Controllers**

---

##  Project Structure

- `AuthController` → عمليات التسجيل، تسجيل الدخول، تسجيل الخروج  
- `UserController` → إدارة المستخدمين + الصلاحيات  
- `Role` Model / Table → تحديد دور كل مستخدم  
- Middleware `jwt.auth` → حماية المسارات  
- Policies → للتحكم بصلاحيات الـ admin  

---
## License

هذا المشروع مفتوح المصدر ويمكن استخدامه لأغراض التعليم والتدريب.
---
##  Installation & Setup
## Installation & Setup

1. Clone المشروع:

   ```bash
   git clone <[repository-url](https://github.com/mahertizeeni/Apostrophy)>
   ```

2. ادخل لمجلد المشروع:

   ```bash
   cd project-name
   ```

3. ثبّت الاعتمادات باستخدام Composer:

   ```bash
   composer install
   ```

4. انسخ ملف البيئة:

   ```bash
   cp .env.example .env
   ```

5. أنشئ مفتاح التطبيق:

   ```bash
   php artisan key:generate
   ```

6. حدّث إعدادات قاعدة البيانات داخل ملف `.env`.

7. شغّل المايغريشن:

   ```bash
   php artisan migrate
   ```

8. شغّل السيرفر:

   ```bash
   php artisan serve
   ```
