from facebook_scraper import get_posts
# posts = list(get_posts(
#     post_urls=["https://m.facebook.com/story.php?story_fbid=3561441294135091&id=3106382216330063"],
#     cookies="cookies.txt"
# ))
# print(posts[0]['post_text'])



# Lấy các bài đăng mới nhất trên trang nhất định
for  post in get_posts(group='hcmusec', pages=1):
    print(post)
