# Multi-Company API (Laravel 12 + Sanctum)

This is a **Laravel 12 API project** built as per the technical assignment requirements.  
The system supports multiple companies per user, with the ability to **switch the active company**.  
All operations (like creating projects) happen **inside the currently active company**.

---

## Features
- **User Authentication** using Laravel Sanctum (Register, Login, Logout)
- **Company CRUD** (per user)
- **Active Company Management** (`user_active_companies` table)
- **Projects CRUD** — all project operations are scoped to the active company only
- **Validation** using Laravel's `Validator` facade with proper error messages
- **RESTful API** following Laravel best practices

---

**Install Dependencies**
run command 1-> composer install
2 -> npm i

**Configure Environment**
rename .env.example file  to .env
Generate Application Key -> php artisan key:generate

**Install & Configure Sanctum**
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"

**Run Migrations**
php artisan migrate

**Start the Development Server**
php artisan serve

The API will be available at:
http://127.0.0.1:8000/api/

--------------------------------------------------------------------------
**API Endpoints** 
Auth
<!-- API Endpoints Table -->
<table style="width:100%; border-collapse:collapse; font-family: Arial, sans-serif;">
  <thead>
    <tr>
      <th style="text-align:left; padding:8px; border-bottom:2px solid #333;">Method</th>
      <th style="text-align:left; padding:8px; border-bottom:2px solid #333;">Endpoint</th>
      <th style="text-align:left; padding:8px; border-bottom:2px solid #333;">Description</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="padding:8px; border-bottom:1px solid #ddd;">POST</td>
      <td style="padding:8px; border-bottom:1px solid #ddd;">/register</td>
      <td style="padding:8px; border-bottom:1px solid #ddd;">User registration</td>
    </tr>
    <tr>
      <td style="padding:8px; border-bottom:1px solid #ddd;">POST</td>
      <td style="padding:8px; border-bottom:1px solid #ddd;">/login</td>
      <td style="padding:8px; border-bottom:1px solid #ddd;">User login</td>
    </tr>
    <tr>
      <td style="padding:8px; border-bottom:1px solid #ddd;">POST</td>
      <td style="padding:8px; border-bottom:1px solid #ddd;">/logout</td>
      <td style="padding:8px; border-bottom:1px solid #ddd;">User logout</td>
    </tr>
    <tr>
      <td style="padding:8px;">GET</td>
      <td style="padding:8px;">/user</td>
      <td style="padding:8px;">Get logged-in user</td>
    </tr>
  </tbody>
</table>




Companies
Method	Endpoint	            Description
GET	    /companies	            List companies
POST	/companies	            Create new company
PUT	    /companies/{id}	        Update company
DELETE	/companies/{id}	        Delete company
POST	/companies/{id}/switch	Set active company


Projects (Active Company Only)
Method	Endpoint	        Description
GET	    /projects	        List projects in active company
POST	/projects	        Create project
PUT	    /projects/{id}	    Update project
DELETE	/projects/{id}	    Delete project


**Rules as per Assignment**
1. A user can have multiple companies.
2. Only one company can be active for a user at a time (user_active_companies table).
3. All project-related operations are only allowed within the active company.
4. Proper validation and error handling is required for every endpoint.
5. Use Laravel's built-in Validator facade for request validation.
6. All APIs must be tested via Postman


**Postman Testing Guide**
1. Set Authorization: Bearer <token> in headers for all authenticated requests.
2. Use Content-Type: application/json when sending raw JSON body.

