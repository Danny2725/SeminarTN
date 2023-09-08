import mysql.connector
from facebook_scraper import get_posts
from urllib.parse import urlparse, parse_qs
import sys
import requests

# Kết nối tới cơ sở dữ liệu MySQL
mydb = mysql.connector.connect(
    host="sql203.epizy.com",
    user="epiz_34283917",
    password="4LCuEN0HmV70TLk",
    database="epiz_34283917_datafb"
)

mycursor = mydb.cursor()

# Tạo bảng fanpages nếu chưa tồn tại
mycursor.execute("""CREATE TABLE IF NOT EXISTS fanpages (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                url VARCHAR(255) NOT NULL)""")

# Tạo bảng `posts` nếu chưa tồn tại
mycursor.execute("""CREATE TABLE IF NOT EXISTS posts (
                id INT AUTO_INCREMENT PRIMARY KEY,
                fanpage_name VARCHAR(255),
                post_id VARCHAR(255) UNIQUE,
                user_name VARCHAR(255),
                post_content TEXT,
                created_time DATETIME,
                image TEXT,
                fbid_image VARCHAR(255))""")

# Tạo bảng `posts_items` nếu chưa tồn tại
mycursor.execute("""CREATE TABLE IF NOT EXISTS posts_items (
                id INT AUTO_INCREMENT PRIMARY KEY,
                fanpage_name VARCHAR(255),
                post_id VARCHAR(255),
                image_items TEXT,
                image_content TEXT,
                fbid_image_items VARCHAR(255))""")

# Thêm danh sách các fanpage vào bảng fanpages (nếu chưa tồn tại)
fanpages = [
    ('SV.HCMUS', 'https://www.facebook.com/groups/SV.HCMUS'),
    ('hcmusec', 'https://www.facebook.com/hcmusec'),
    ('valorantvietnam', 'https://www.facebook.com/groups/valorantvietnam'),
    ('echcmute', 'https://www.facebook.com/groups/echcmute')
    
]
for fanpage in fanpages:
    sql_check = "SELECT id FROM fanpages WHERE name = %s"
    val_check = (fanpage[0],)
    mycursor.execute(sql_check, val_check)
    result = mycursor.fetchone()
    if result is None:
        # Fanpage chưa tồn tại trong cơ sở dữ liệu, thêm vào
        sql_insert = "INSERT INTO fanpages (name, url) VALUES (%s, %s)"
        val_insert = (fanpage[0], fanpage[1])
        mycursor.execute(sql_insert, val_insert)
        mydb.commit()
    else:
        print("Fanpage already exists:", fanpage[0])

# Lấy danh sách các fanpage từ bảng fanpages
mycursor.execute("SELECT * FROM fanpages")
fanpages = mycursor.fetchall()

# Lấy dữ liệu bài đăng trên Facebook và đồng bộ vào cơ sở dữ liệu MySQL
for fanpage in fanpages:    
    for post in get_posts(group=fanpage[1], pages=2):
        # Kiểm tra xem post_id đã tồn tại trong cơ sở dữ liệu chưa
        mycursor.execute("SELECT * FROM posts WHERE post_id = %s", (post['post_id'],))
        result = mycursor.fetchone()
        if result is None:
            # Thêm dữ liệu vào bảng `posts`
            sql = "INSERT INTO posts (fanpage_name, post_id, user_name, post_content, created_time, image) VALUES (%s, %s, %s, %s, %s, %s)"
            val = (fanpage[1], post['post_id'], post['username'], post['text'], post['time'], post['image'])
            mycursor.execute(sql, val)
            mydb.commit()

            # Trích xuất ID hình ảnh và cập nhật vào cột fbid_image (nếu có)
            if post['image'] is not None:
                image_id = None
                parsed_url = urlparse(post['image'])
                parsed_qs = parse_qs(parsed_url.query)
                if 'fbid' in parsed_qs:
                    image_id = parsed_qs['fbid'][0]
                
                sql_update = "UPDATE posts SET fbid_image = %s WHERE post_id = %s"
                val_update = (image_id, post['post_id'])
                mycursor.execute(sql_update, val_update)
                mydb.commit()

            # Thêm dữ liệu vào bảng `posts_items` cho các hình ảnh khác (nếu có)
            if post['images'] is not None and len(post['images']) > 1:
                for i in range(1, len(post['images'])):
                    sql = "INSERT INTO posts_items (fanpage_name, post_id, image_items, image_content) VALUES (%s, %s, %s, %s)"
                    val = (fanpage[1], post['post_id'], post['images'][i], post['text'])
                    mycursor.execute(sql, val)
                    mydb.commit()
                    
                    # Trích xuất ID hình ảnh và cập nhật vào cột fbid_image_items (nếu có)
                    if post['images'][i] is not None:
                        image_id_items = None
                        parsed_url_items = urlparse(post['images'][i])
                        parsed_qs_items = parse_qs(parsed_url_items.query)
                        if 'fbid' in parsed_qs_items:
                            image_id_items = parsed_qs_items['fbid'][0]
                        
                        sql_update_items = "UPDATE posts_items SET fbid_image_items = %s WHERE image_items = %s"
                        val_update_items = (image_id_items, post['images'][i])
                        mycursor.execute(sql_update_items, val_update_items)
                        mydb.commit()

    # Lấy danh sách các bài đăng và cập nhật nội dung hình ảnh vào cơ sở dữ liệu
    mycursor.execute("SELECT post_id, fbid_image_items FROM posts_items")
    posts_items = mycursor.fetchall()

    for post_id, fbid_image_items in posts_items:
        if fbid_image_items and post_id:
            url = "https://m.facebook.com/story.php?story_fbid={fbid}&id={user_id}".format(
                fbid=fbid_image_items,
                user_id=post_id
            )
            response = requests.get(url)
            if response.status_code == 200:
                posts = list(get_posts(post_urls=[url], cookies="cookies.txt"))
                if len(posts) > 0:
                    image_content = posts[0]["post_text"]
                    # Cập nhật dữ liệu vào cơ sở dữ liệu
                    sql_update_items = "UPDATE posts_items SET image_content = %s WHERE post_id = %s"
                    val_update_items = (image_content, post_id)
                    mycursor.execute(sql_update_items, val_update_items)
                    mydb.commit()
