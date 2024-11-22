# Blogit (Mini blogging platform created in php and javascript)

This is a semester project of TU(Trivhuvan University) **Project I** of _4th semester_.

## Entities

- Database
  ```sql
  CREATE DATABASE IF NOT EXISTS blogit;
  ```
- Users

  ```sql
  CREATE TABLE IF NOT EXISTS users (
  id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
  fname VARCHAR(20) NOT NULL,
  lname VARCHAR(20) NOT NULL,
  dob DATE NOT NULL,
  email VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(50) NOT NULL,
  profile_pic VARCHAR(10) NOT NULL
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  );
  ```

- Blogs

  ```sql
  CREATE TABLE IF NOT EXISTS blogs (
    pid CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    uid CHAR(36) NOT NULL,  -- Match the data type with 'id' in users table
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (uid) REFERENCES users(id) ON DELETE CASCADE
  );

  ```

- Comments

  ```sql
  CREATE TABLE IF NOT EXISTS comments (
    cid char(36) PRIMARY KEY DEFAULT (UUID()) ,
    blog_id char(36) NOT NULL,
    user_id char(36) NOT NULL,
    comment varchar(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (blog_id) REFERENCES blogs(pid) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
  );
  ```

- Likes

  ```sql
  CREATE TABLE IF NOT EXISTS likes (
    lid char(36) PRIMARY KEY DEFAULT (UUID()),
    bid char(36) NOT NULL,
    uid char(36) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (bid) REFERENCES blogs(pid) ON DELETE CASCADE,
    FOREIGN KEY (uid) REFERENCES users(id) ON DELETE CASCADE
  );
  ```

- Request For Block

```sql
   CREATE TABLE IF NOT EXISTS blocks (
    block_id char(36) PRIMARY KEY DEFAULT (uuid()),
    block_by char(36) NOT NULL,
    block_to char(36) NOT NULL,
    message VARCHAR(200) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (block_by) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (block_to) REFERENCES users(id) ON DELETE CASCADE,
   );
```

## Admin Part

Admin part is in **_blogit/backend/public/admin_** where it is a protected route.
We have used built in apache feature to make it protected.

To do so install _(in linux)_

`sudo apt-get apache2-utils`

create a file .htpasswd where you can store username and password to that protected route

⚠️ **_WARNING_** : For security reasons, place it outside of where the browser can access, typically outside the htdocs folder.

```
sudo htpasswd -c /opt/lampp/.htpasswd username
# You will be prompted to type a password

```

create a **_.htaccess_** file in a protected folder here in our case in **_/blogit/backend/public/admin_**
And paste the below code.

```
AuthType Basic # type of authentication
AuthName "Admin Area" # name displayed on login board
AuthUserFile /opt/lampp/.htpasswd # path where password is stored
Require valid-user # only valid-user can go further
```

Now when you go to the route you will be prompted to give username and password
Enter earlier username and password stroed in .htpasswd and you are good to go.
