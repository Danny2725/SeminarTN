import mysql.connector
from facebook_scraper import get_posts

# Kết nối đến cơ sở dữ liệu
mydb = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="datafb"
)


mycursor = mydb.cursor()

# Lấy danh sách post_id từ cơ sở dữ liệu
mycursor.execute("SELECT post_id, fbid_image FROM posts")
posts = mycursor.fetchall()
mycursor.execute("SELECT post_id, fbid_image_items FROM posts_items")
post_items = mycursor.fetchall()


# Đọc file cookies
with open("C:/Users\quant/OneDrive/Máy tính/Workspace/Seminar tốt nghiệp/Đồng bộ dữ liệu/cookies.txt", "r") as f:
    cookies = f.read()

# Duyệt qua từng post_id và lấy url của hình ảnh bằng facebook_scraper
for post_id, fbid_image in posts:
    if fbid_image and post_id:
        url = "https://m.facebook.com/story.php?story_fbid={fbid}&id={user_id}".format(
            fbid=fbid_image,
            user_id=post_id
        )
        posts = list(get_posts(post_urls=[url], cookies="cookies.txt"))
        if len(posts) > 0:
            image_url = posts[0]["image"]
            # Cập nhật dữ liệu vào cơ sở dữ liệu
            sql = "UPDATE posts SET image = %s WHERE post_id = %s"
            val = (image_url, post_id)
            mycursor.execute(sql, val)
            mydb.commit()
        
for post_id, fbid_image_items in post_items:
    if fbid_image_items and post_id:
        url = "https://m.facebook.com/story.php?story_fbid={fbid}&id={user_id}".format(
            fbid=fbid_image_items,
            user_id=post_id
        )
        posts = list(get_posts(post_urls=[url], cookies="cookies.txt"))
        if len(posts) > 0:
            image_url_items = posts[0]["image"]
            # Cập nhật dữ liệu vào cơ sở dữ liệu
            sql = "UPDATE posts_items SET image_items = %s WHERE post_id = %s"
            val = (image_url_items, post_id)
            mycursor.execute(sql, val)
            mydb.commit()

