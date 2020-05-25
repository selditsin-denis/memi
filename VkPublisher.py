import requests


class VkPublisher:
    TOKEN = "5aea87f29ac4b4dec7e30d87bbef361b16b61d9c2f7e4b5c066032a600b1f42313966893df605d83bc4199"
    GROUP_ID = 195702735

    img_path = None

    def __init__(self, img_path):
        self.img_path = img_path

    def publish(self):
        server, photo, photo_hash = self.upload_image()
        url_save = f"https://api.vk.com/method/photos.saveWallPhoto?group_id={self.GROUP_ID}&server={server}&photo={photo}&hash={photo_hash}&access_token={self.TOKEN}&v=5.106"
        response_save = requests.get(url_save).json()
        owner_id = response_save.get('response')[0].get('owner_id')
        media_id = response_save.get('response')[0].get('id')
        attachments = f"photo{owner_id}_{media_id}"
        url_post = f"https://api.vk.com/method/wall.post?owner_id=-{self.GROUP_ID}&attachments={attachments}&access_token={self.TOKEN}&v=5.106"
        response_post = requests.get(url_post).json()
        print(response_post)

    def upload_image(self):
        url = f"https://api.vk.com/method/photos.getWallUploadServer?group_id={self.GROUP_ID}&access_token={self.TOKEN}&v=5.106"
        upload_url = requests.get(url).json().get('response').get('upload_url')
        files = {'photo': open(self.img_path, 'rb')}
        r = requests.post(upload_url, files=files)
        return str(r.json().get('server')), str(r.json().get('photo')), str(r.json().get('hash'))
