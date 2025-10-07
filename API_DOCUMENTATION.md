# 📱 API Documentation - B2B Platform Mobile

## 📋 Table des matières

1. [Introduction](#introduction)
2. [Authentication](#authentication)
3. [Products API](#products-api)
4. [Cart API](#cart-api)
5. [Orders API](#orders-api)
6. [Error Handling](#error-handling)
7. [Rate Limiting](#rate-limiting)

---

## 🎯 Introduction

### Base URL
```
Production: https://your-domain.com/api/v1
Development: http://127.0.0.1:8001/api/v1
```

### Authentication
All protected endpoints require a Bearer token in the Authorization header:

```http
Authorization: Bearer {your_api_token}
```

### Response Format
All responses follow this format:

```json
{
    "success": true|false,
    "message": "Human readable message",
    "data": {...},
    "errors": {...}  // Only present on validation errors
}
```

### HTTP Status Codes
- `200` - OK
- `201` - Created
- `400` - Bad Request
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not Found
- `422` - Validation Error
- `500` - Server Error

---

## 🔐 Authentication

### Register
Create a new user account.

**Endpoint:** `POST /register`

**Request:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "role": "vendeur",
    "company_name": "ABC Company",
    "phone": "+216 12 345 678",
    "address": "123 Main Street",
    "city": "Tunis",
    "postal_code": "1000",
    "preferred_language": "fr",
    "tenant_id": 1
}
```

**Response:** `201 Created`
```json
{
    "success": true,
    "message": "User registered successfully",
    "data": {
        "user": {
            "id": 5,
            "name": "John Doe",
            "email": "john@example.com",
            "role": "vendeur",
            "company_name": "ABC Company",
            "phone": "+216 12 345 678",
            "preferred_language": "fr",
            "tenant_id": 1
        },
        "token": "1|abc123def456...",
        "token_type": "Bearer"
    }
}
```

---

### Login
Authenticate and get an API token.

**Endpoint:** `POST /login`

**Request:**
```json
{
    "email": "john@example.com",
    "password": "password123",
    "device_name": "iPhone 14 Pro" // Optional
}
```

**Response:** `200 OK`
```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": {
            "id": 5,
            "name": "John Doe",
            "email": "john@example.com",
            "role": "vendeur",
            "company_name": "ABC Company",
            "phone": "+216 12 345 678",
            "address": "123 Main Street",
            "city": "Tunis",
            "postal_code": "1000",
            "preferred_language": "fr",
            "tenant_id": 1,
            "group_id": null
        },
        "token": "2|xyz789uvw456...",
        "token_type": "Bearer"
    }
}
```

---

### Logout
Revoke current device token.

**Endpoint:** `POST /logout`

**Headers:** `Authorization: Bearer {token}`

**Response:** `200 OK`
```json
{
    "success": true,
    "message": "Logged out successfully"
}
```

---

### Logout All Devices
Revoke all tokens for the user.

**Endpoint:** `POST /logout-all`

**Headers:** `Authorization: Bearer {token}`

**Response:** `200 OK`
```json
{
    "success": true,
    "message": "Logged out from all devices successfully"
}
```

---

### Get Profile
Get authenticated user's profile.

**Endpoint:** `GET /profile`

**Headers:** `Authorization: Bearer {token}`

**Response:** `200 OK`
```json
{
    "success": true,
    "data": {
        "user": {
            "id": 5,
            "name": "John Doe",
            "email": "john@example.com",
            "role": "vendeur",
            "company_name": "ABC Company",
            "phone": "+216 12 345 678",
            "address": "123 Main Street",
            "city": "Tunis",
            "postal_code": "1000",
            "preferred_language": "fr",
            "tenant_id": 1,
            "group_id": null,
            "is_active": true,
            "created_at": "2025-10-06T10:30:00.000000Z"
        }
    }
}
```

---

### Update Profile
Update user profile information.

**Endpoint:** `PUT /profile`

**Headers:** `Authorization: Bearer {token}`

**Request:**
```json
{
    "name": "John Updated",
    "phone": "+216 98 765 432",
    "address": "456 New Street",
    "city": "Sfax",
    "postal_code": "3000",
    "preferred_language": "en"
}
```

**Response:** `200 OK`
```json
{
    "success": true,
    "message": "Profile updated successfully",
    "data": {
        "user": {
            "id": 5,
            "name": "John Updated",
            "email": "john@example.com",
            "role": "vendeur",
            "company_name": "ABC Company",
            "phone": "+216 98 765 432",
            "address": "456 New Street",
            "city": "Sfax",
            "postal_code": "3000",
            "preferred_language": "en"
        }
    }
}
```

---

### Change Password
Change user password.

**Endpoint:** `POST /change-password`

**Headers:** `Authorization: Bearer {token}`

**Request:**
```json
{
    "current_password": "oldpassword123",
    "new_password": "newpassword456",
    "new_password_confirmation": "newpassword456"
}
```

**Response:** `200 OK`
```json
{
    "success": true,
    "message": "Password changed successfully"
}
```

---

## 📦 Products API

### Get Products List
Get paginated list of products with filters.

**Endpoint:** `GET /products`

**Headers:** `Authorization: Bearer {token}`

**Query Parameters:**
- `search` (string) - Search in name, description, SKU
- `category_id` (integer) - Filter by category
- `min_price` (decimal) - Minimum price filter
- `max_price` (decimal) - Maximum price filter
- `in_stock` (boolean) - Only show products in stock
- `sort_by` (string) - Sort field: `name`, `price`, `stock_quantity`, `created_at`
- `sort_order` (string) - `asc` or `desc`
- `per_page` (integer) - Items per page (default: 20)

**Example Request:**
```http
GET /products?search=laptop&category_id=2&in_stock=true&sort_by=price&sort_order=asc&per_page=10
```

**Response:** `200 OK`
```json
{
    "success": true,
    "data": {
        "products": [
            {
                "id": 1,
                "name": "Laptop Dell XPS 15",
                "sku": "DELL-XPS-15",
                "description": "High-performance laptop with Intel Core i7...",
                "price": 2499.99,
                "original_price": null,
                "discount_percentage": null,
                "stock_quantity": 15,
                "in_stock": true,
                "is_active": true,
                "category": {
                    "id": 2,
                    "name": "Electronics",
                    "slug": "electronics"
                },
                "images": [
                    {
                        "id": 1,
                        "url": "http://127.0.0.1:8001/storage/products/laptop1.jpg",
                        "is_cover": true
                    }
                ],
                "main_image": "http://127.0.0.1:8001/storage/products/laptop1.jpg"
            }
        ],
        "pagination": {
            "current_page": 1,
            "total_pages": 5,
            "per_page": 10,
            "total": 48
        }
    }
}
```

---

### Get Product Details
Get detailed information about a specific product.

**Endpoint:** `GET /products/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response:** `200 OK`
```json
{
    "success": true,
    "data": {
        "product": {
            "id": 1,
            "name": "Laptop Dell XPS 15",
            "sku": "DELL-XPS-15",
            "description": "High-performance laptop with Intel Core i7, 16GB RAM, 512GB SSD...",
            "price": 2499.99,
            "original_price": 2799.99,
            "discount_percentage": 10.71,
            "stock_quantity": 15,
            "in_stock": true,
            "is_active": true,
            "unit": "piece",
            "weight": 1.8,
            "dimensions": "35.7 x 23.5 x 1.7 cm",
            "category": {
                "id": 2,
                "name": "Electronics",
                "slug": "electronics"
            },
            "images": [
                {
                    "id": 1,
                    "url": "http://127.0.0.1:8001/storage/products/laptop1.jpg",
                    "is_cover": true
                },
                {
                    "id": 2,
                    "url": "http://127.0.0.1:8001/storage/products/laptop2.jpg",
                    "is_cover": false
                }
            ],
            "main_image": "http://127.0.0.1:8001/storage/products/laptop1.jpg",
            "created_at": "2025-10-01T08:00:00.000000Z",
            "updated_at": "2025-10-06T12:00:00.000000Z"
        }
    }
}
```

---

### Search Products
Quick search for products.

**Endpoint:** `GET /products/search?q={query}`

**Headers:** `Authorization: Bearer {token}`

**Query Parameters:**
- `q` (string, required) - Search query

**Response:** `200 OK`
```json
{
    "success": true,
    "data": {
        "products": [...],
        "total": 5
    }
}
```

---

### Get Featured Products
Get featured/latest products.

**Endpoint:** `GET /products/featured`

**Headers:** `Authorization: Bearer {token}`

**Query Parameters:**
- `limit` (integer) - Number of products (default: 10)

**Response:** `200 OK`
```json
{
    "success": true,
    "data": {
        "products": [...]
    }
}
```

---

### Get Categories
Get all product categories.

**Endpoint:** `GET /products/categories`

**Headers:** `Authorization: Bearer {token}`

**Response:** `200 OK`
```json
{
    "success": true,
    "data": {
        "categories": [
            {
                "id": 1,
                "name": "Electronics",
                "slug": "electronics",
                "description": "Electronic devices and accessories",
                "products_count": 24
            },
            {
                "id": 2,
                "name": "Office Supplies",
                "slug": "office-supplies",
                "description": "Office equipment and supplies",
                "products_count": 18
            }
        ]
    }
}
```

---

## 🛒 Cart API

### Get Cart
Get current user's cart with all items.

**Endpoint:** `GET /cart`

**Headers:** `Authorization: Bearer {token}`

**Response:** `200 OK`
```json
{
    "success": true,
    "data": {
        "cart": {
            "id": 12,
            "created_at": "2025-10-06T10:00:00.000000Z",
            "updated_at": "2025-10-06T14:30:00.000000Z"
        },
        "items": [
            {
                "id": 25,
                "quantity": 2,
                "price": 2499.99,
                "subtotal": 4999.98,
                "product": {
                    "id": 1,
                    "name": "Laptop Dell XPS 15",
                    "sku": "DELL-XPS-15",
                    "stock_quantity": 15,
                    "in_stock": true,
                    "main_image": "http://127.0.0.1:8001/storage/products/laptop1.jpg"
                }
            }
        ],
        "summary": {
            "subtotal": 4999.98,
            "tax": 999.99,
            "total": 5999.97,
            "items_count": 2,
            "discount": 0,
            "discount_code": null
        }
    }
}
```

---

### Add to Cart
Add a product to cart.

**Endpoint:** `POST /cart/add`

**Headers:** `Authorization: Bearer {token}`

**Request:**
```json
{
    "product_id": 1,
    "quantity": 2
}
```

**Response:** `200 OK`
```json
{
    "success": true,
    "message": "Product added to cart successfully",
    "data": {
        "cart_item": {
            "id": 25,
            "quantity": 2,
            "price": 2499.99,
            "subtotal": 4999.98
        },
        "cart_summary": {
            "subtotal": 4999.98,
            "tax": 999.99,
            "total": 5999.97,
            "items_count": 2
        }
    }
}
```

---

### Update Cart Item
Update quantity of a cart item.

**Endpoint:** `PUT /cart/items/{itemId}`

**Headers:** `Authorization: Bearer {token}`

**Request:**
```json
{
    "quantity": 5
}
```

**Response:** `200 OK`
```json
{
    "success": true,
    "message": "Cart item updated successfully",
    "data": {
        "cart_item": {
            "id": 25,
            "quantity": 5,
            "subtotal": 12499.95
        },
        "cart_summary": {
            "subtotal": 12499.95,
            "tax": 2499.99,
            "total": 14999.94,
            "items_count": 5
        }
    }
}
```

---

### Remove from Cart
Remove an item from cart.

**Endpoint:** `DELETE /cart/items/{itemId}`

**Headers:** `Authorization: Bearer {token}`

**Response:** `200 OK`
```json
{
    "success": true,
    "message": "Item removed from cart successfully",
    "data": {
        "cart_summary": {
            "subtotal": 0,
            "tax": 0,
            "total": 0,
            "items_count": 0
        }
    }
}
```

---

### Clear Cart
Remove all items from cart.

**Endpoint:** `POST /cart/clear`

**Headers:** `Authorization: Bearer {token}`

**Response:** `200 OK`
```json
{
    "success": true,
    "message": "Cart cleared successfully"
}
```

---

### Get Cart Count
Get number of items in cart.

**Endpoint:** `GET /cart/count`

**Headers:** `Authorization: Bearer {token}`

**Response:** `200 OK`
```json
{
    "success": true,
    "data": {
        "count": 5
    }
}
```

---

### Apply Discount Code
Apply a discount code to cart.

**Endpoint:** `POST /cart/discount`

**Headers:** `Authorization: Bearer {token}`

**Request:**
```json
{
    "code": "SUMMER2025"
}
```

**Response:** `200 OK`
```json
{
    "success": true,
    "message": "Discount code applied successfully",
    "data": {
        "cart_summary": {
            "subtotal": 4999.98,
            "discount": 499.99,
            "tax": 900.00,
            "total": 5399.99,
            "items_count": 2
        }
    }
}
```

---

## 📋 Orders API

### Get Orders List
Get user's orders with pagination and filters.

**Endpoint:** `GET /orders`

**Headers:** `Authorization: Bearer {token}`

**Query Parameters:**
- `status` (string) - Filter by status: `pending`, `confirmed`, `processing`, `shipped`, `delivered`, `cancelled`
- `from_date` (date) - Filter from date (YYYY-MM-DD)
- `to_date` (date) - Filter to date (YYYY-MM-DD)
- `sort_by` (string) - Sort field: `created_at`, `total_amount`, `status`
- `sort_order` (string) - `asc` or `desc`
- `per_page` (integer) - Items per page (default: 20)

**Response:** `200 OK`
```json
{
    "success": true,
    "data": {
        "orders": [
            {
                "id": 42,
                "order_number": "ORD-20251006-A3B7C2",
                "status": "pending",
                "payment_status": "pending",
                "payment_method": "credit_card",
                "subtotal": 4999.98,
                "tax": 999.99,
                "shipping_cost": 0,
                "discount": 0,
                "total_amount": 5999.97,
                "created_at": "2025-10-06T15:30:00.000000Z",
                "status_label": "Pending",
                "items_count": 2
            }
        ],
        "pagination": {
            "current_page": 1,
            "total_pages": 3,
            "per_page": 20,
            "total": 52
        }
    }
}
```

---

### Get Order Details
Get detailed information about a specific order.

**Endpoint:** `GET /orders/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response:** `200 OK`
```json
{
    "success": true,
    "data": {
        "order": {
            "id": 42,
            "order_number": "ORD-20251006-A3B7C2",
            "status": "pending",
            "payment_status": "pending",
            "payment_method": "credit_card",
            "subtotal": 4999.98,
            "tax": 999.99,
            "shipping_cost": 0,
            "discount": 0,
            "total_amount": 5999.97,
            "shipping_address": "123 Main Street",
            "shipping_city": "Tunis",
            "shipping_postal_code": "1000",
            "shipping_phone": "+216 12 345 678",
            "notes": "Please deliver before 5 PM",
            "items": [
                {
                    "id": 85,
                    "quantity": 2,
                    "price": 2499.99,
                    "subtotal": 4999.98,
                    "product": {
                        "id": 1,
                        "name": "Laptop Dell XPS 15",
                        "sku": "DELL-XPS-15",
                        "main_image": "http://127.0.0.1:8001/storage/products/laptop1.jpg"
                    }
                }
            ],
            "created_at": "2025-10-06T15:30:00.000000Z",
            "updated_at": "2025-10-06T15:30:00.000000Z",
            "status_label": "Pending"
        }
    }
}
```

---

### Create Order
Create a new order from current cart.

**Endpoint:** `POST /orders`

**Headers:** `Authorization: Bearer {token}`

**Request:**
```json
{
    "shipping_address": "123 Main Street",
    "shipping_city": "Tunis",
    "shipping_postal_code": "1000",
    "shipping_phone": "+216 12 345 678",
    "payment_method": "credit_card",
    "notes": "Please deliver before 5 PM"
}
```

**Response:** `201 Created`
```json
{
    "success": true,
    "message": "Order created successfully",
    "data": {
        "order": {
            "id": 42,
            "order_number": "ORD-20251006-A3B7C2",
            "status": "pending",
            "payment_status": "pending",
            "payment_method": "credit_card",
            "subtotal": 4999.98,
            "tax": 999.99,
            "shipping_cost": 0,
            "discount": 0,
            "total_amount": 5999.97,
            "shipping_address": "123 Main Street",
            "shipping_city": "Tunis",
            "shipping_postal_code": "1000",
            "shipping_phone": "+216 12 345 678",
            "notes": "Please deliver before 5 PM",
            "items": [...],
            "created_at": "2025-10-06T15:30:00.000000Z",
            "updated_at": "2025-10-06T15:30:00.000000Z",
            "status_label": "Pending"
        }
    }
}
```

---

### Cancel Order
Cancel a pending order.

**Endpoint:** `POST /orders/{id}/cancel`

**Headers:** `Authorization: Bearer {token}`

**Response:** `200 OK`
```json
{
    "success": true,
    "message": "Order cancelled successfully",
    "data": {
        "order": {
            "id": 42,
            "order_number": "ORD-20251006-A3B7C2",
            "status": "cancelled",
            "payment_status": "pending",
            "payment_method": "credit_card",
            "total_amount": 5999.97,
            "created_at": "2025-10-06T15:30:00.000000Z",
            "status_label": "Cancelled",
            "items_count": 2
        }
    }
}
```

---

### Get Order Statistics
Get user's order statistics.

**Endpoint:** `GET /orders/statistics`

**Headers:** `Authorization: Bearer {token}`

**Response:** `200 OK`
```json
{
    "success": true,
    "data": {
        "total_orders": 52,
        "pending_orders": 3,
        "completed_orders": 45,
        "cancelled_orders": 4,
        "total_spent": 125498.75,
        "recent_orders": [...]
    }
}
```

---

## ❌ Error Handling

### Validation Error (422)
```json
{
    "success": false,
    "message": "Validation errors",
    "errors": {
        "email": [
            "The email field is required."
        ],
        "password": [
            "The password must be at least 8 characters."
        ]
    }
}
```

### Authentication Error (401)
```json
{
    "success": false,
    "message": "Invalid credentials"
}
```

### Not Found Error (404)
```json
{
    "success": false,
    "message": "Product not found"
}
```

### Server Error (500)
```json
{
    "success": false,
    "message": "Failed to create order: Database connection error"
}
```

---

## ⚡ Rate Limiting

API requests are rate-limited to prevent abuse:

- **Authenticated requests:** 60 requests per minute
- **Unauthenticated requests:** 10 requests per minute

When rate limit is exceeded, you'll receive a `429 Too Many Requests` response:

```json
{
    "message": "Too Many Attempts.",
    "exception": "Illuminate\\Http\\Exceptions\\ThrottleRequestsException"
}
```

Rate limit headers are included in responses:
```http
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 57
X-RateLimit-Reset: 1696603200
```

---

## 📱 Mobile App Integration Examples

### Flutter Example

```dart
// Login
final response = await http.post(
  Uri.parse('$baseUrl/login'),
  headers: {'Content-Type': 'application/json'},
  body: jsonEncode({
    'email': email,
    'password': password,
    'device_name': 'Flutter App',
  }),
);

final data = jsonDecode(response.body);
if (data['success']) {
  final token = data['data']['token'];
  // Save token for future requests
  await storage.write(key: 'api_token', value: token);
}

// Get products with token
final productsResponse = await http.get(
  Uri.parse('$baseUrl/products'),
  headers: {
    'Authorization': 'Bearer $token',
    'Accept': 'application/json',
  },
);
```

### React Native Example

```javascript
// Login
const login = async (email, password) => {
  const response = await fetch(`${BASE_URL}/login`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      email,
      password,
      device_name: 'React Native App',
    }),
  });

  const data = await response.json();
  if (data.success) {
    await AsyncStorage.setItem('api_token', data.data.token);
    return data.data.user;
  }
  throw new Error(data.message);
};

// Get cart
const getCart = async () => {
  const token = await AsyncStorage.getItem('api_token');
  const response = await fetch(`${BASE_URL}/cart`, {
    headers: {
      'Authorization': `Bearer ${token}`,
      'Accept': 'application/json',
    },
  });

  return response.json();
};
```

---

## 🔧 Testing with Postman

### Setup Postman Environment

1. Create new environment "B2B API Development"
2. Add variables:
   - `base_url` = `http://127.0.0.1:8001/api/v1`
   - `token` = (will be set after login)

### Example Collection Structure

```
B2B Platform API
├── Authentication
│   ├── Register
│   ├── Login (saves token to environment)
│   ├── Get Profile
│   ├── Update Profile
│   ├── Change Password
│   ├── Logout
│   └── Logout All
├── Products
│   ├── Get Products
│   ├── Get Product Details
│   ├── Search Products
│   ├── Get Featured
│   └── Get Categories
├── Cart
│   ├── Get Cart
│   ├── Add to Cart
│   ├── Update Item
│   ├── Remove Item
│   ├── Clear Cart
│   ├── Get Count
│   └── Apply Discount
└── Orders
    ├── Get Orders
    ├── Get Order Details
    ├── Create Order
    ├── Cancel Order
    └── Get Statistics
```

### Postman Pre-request Script (for Login)

```javascript
// After successful login, save token
pm.test("Save token", function () {
    var jsonData = pm.response.json();
    if (jsonData.success && jsonData.data.token) {
        pm.environment.set("token", jsonData.data.token);
    }
});
```

---

**📅 Last Updated:** October 6, 2025
**📌 API Version:** 1.0
**🎯 Status:** Production Ready

For support or questions, contact the development team.
