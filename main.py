from Lobsterator import Lobsterator
from VkPublisher import VkPublisher

if __name__ == '__main__':
    img = r"img\cat.png"
    text = "мемный кекст"

    # lobster = Lobsterator(img, text)
    # lobster.lobsterate()

    vkpub = VkPublisher(img)
    vkpub.publish()
