# 3D Model File Upload API

This project provides an API for uploading 3D model files with extensions `.usdz` and `.glb` to an AWS S3 bucket. It also allows users to add captions to their files, and provides CRUD endpoints for managing these files.

## Features

- User registration and login with token-based authentication
- Upload 3D model files to AWS S3
- Add captions to uploaded files
- Fetch details of all uploaded files
- Update captions of uploaded files
- Delete files from AWS S3 and the database
- Protected routes for authenticated users

## Requirements

- PHP 8.0+
- Laravel 11+
- AWS S3 bucket
- Composer

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/Marlz74/3D_models.git
    cd 3d-model-upload-api
    ```

2. Install dependencies:
    ```bash
    composer install
    ```

3. Copy the [.env.example](http://_vscodecontentref_/1) file to [.env](http://_vscodecontentref_/2) and configure your environment variables, including database and AWS S3 credentials:
    ```bash
    cp .env.example .env
    ```

4. Generate an application key:
    ```bash
    php artisan key:generate
    ```

5. Run the database migrations:
    ```bash
    php artisan migrate
    ```

6. Install Laravel Sanctum:
    ```bash
    composer require laravel/sanctum
    php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
    php artisan migrate
    ```


## Usage

### Authentication Endpoints

#### Register

- **URL**: `/auth/register`
- **Method**: `POST`
- **Request Body**:
    ```json
    {
        "name": "John Doe",
        "email": "john.doe@example.com",
        "password": "secret123",
        "password_confirmation": "secret123"
    }
    ```
- **Response**:
    ```json
    {
        "user": {
            "name": "John Doe",
            "email": "john.doe@example.com",
            "updated_at": "2025-02-15T11:18:29.000000Z",
            "created_at": "2025-02-15T11:18:29.000000Z",
            "id": 3
        },
        "access_token": "your-access-token"
    }
    ```

#### Login

- **URL**: `/auth/login`
- **Method**: `POST`
- **Request Body**:
    ```json
    {
        "email": "john.doe@example.com",
        "password": "secret123"
    }
    ```
- **Response**:
    ```json
    {
        "user": {
            "name": "John Doe",
            "email": "john.doe@example.com",
            "updated_at": "2025-02-15T11:18:29.000000Z",
            "created_at": "2025-02-15T11:18:29.000000Z",
            "id": 3
        },
        "access_token": "your-access-token"
    }
    ```

### File Management Endpoints

#### Upload File

- **URL**: `/upload`
- **Method**: `POST`
- **Request Body** (multipart/form-data):
    - `file`: The 3D model file (`.usdz` or `.glb`)
    - `caption`: The caption for the file
- **Response**:
    ```json
    {
        "message": "File uploaded successfully",
        "data": {
            "id": 1,
            "file_url": "https://your-s3-bucket-url/3d_models/filename.usdz",
            "caption": "Your caption",
            "created_at": "2023-10-01T00:00:00.000000Z",
            "updated_at": "2023-10-01T00:00:00.000000Z"
        }
    }
    ```

#### List Files

- **URL**: `/list`
- **Method**: `GET`
- **Response**:
    ```json
    {
        "data": [
            {
                "id": 1,
                "file_url": "https://your-s3-bucket-url/3d_models/filename.usdz",
                "caption": "Your caption",
                "created_at": "2023-10-01T00:00:00.000000Z",
                "updated_at": "2023-10-01T00:00:00.000000Z"
            }
        ]
    }
    ```

#### Update File Caption

- **URL**: `/update/{id}`
- **Method**: `PUT`
- **Request Body**:
    ```json
    {
        "caption": "Updated caption"
    }
    ```
- **Response**:
    ```json
    {
        "message": "File updated successfully",
        "data": {
            "id": 1,
            "file_url": "https://your-s3-bucket-url/3d_models/filename.usdz",
            "caption": "Updated caption",
            "created_at": "2023-10-01T00:00:00.000000Z",
            "updated_at": "2023-10-01T00:00:00.000000Z"
        }
    }
    ```

#### Delete File

- **URL**: `/delete/{id}`
- **Method**: `DELETE`
- **Response**:
    ```json
    {
        "message": "File deleted successfully"
    }
    ```

### User Profile Endpoint

#### Get Profile

- **URL**: `/profile`
- **Method**: `GET`
- **Headers**: `Authorization: Bearer your-access-token`
- **Response**:
    ```json
    {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john.doe@example.com",
            "created_at": "2023-10-01T00:00:00.000000Z",
            "updated_at": "2023-10-01T00:00:00.000000Z"
        }
    }
    ```

## License

This project is licensed under the MIT License. See the LICENSE file for details.