from Lobsterator import Lobsterator
from VkPublisher import VkPublisher
from Translator import Translator

if __name__ == '__main__':
    img = r"img\cat.png"  # путь к шаблону мема
    text_en = "Dog"  # тут будет получение мемного текста с тензорфлоу на инглише

    # переводим мемный текст
    translator = Translator(text_en)
    text_ru = translator.translate() + ")"  # тут теперь хранится перевод

    # лобстерируем картинку, получаем готовый мем в папку result и получаем путь к готовому мему
    lobster = Lobsterator(img, text_ru)
    meme = lobster.lobsterate()

    # загружаем в предложку
    vkpub = VkPublisher(meme)
    vkpub.publish()
