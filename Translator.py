import requests


class Translator:
    URL = 'https://translate.yandex.net/api/v1.5/tr.json/translate?'
    KEY = 'trnsl.1.1.20160530T115212Z.bb853798efcc4f27.79bbe71d46f7a63f99acb6c9975159433f749862'
    LANG = 'ru-en', 'en-ru'

    text = ""

    def __init__(self, text):
        self.text = text

    def translate(self):
        response = requests.post(self.URL, data={'key': self.KEY, 'text': self.text, 'lang': self.LANG})
        return response.json().get("text")[0]
