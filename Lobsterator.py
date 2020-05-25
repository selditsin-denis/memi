from PIL import Image, ImageDraw, ImageFont
import os
import cv2


class Lobsterator:
    text = None
    img_path = None

    def __init__(self, img_path: str, text: str):
        self.text = text
        self.img_path = img_path

    def lobsterate(self):
        if not os.path.exists(self.img_path):
            raise IOError("Изображение по данному пути не найдено: " + self.img_path)

        img = Image.open(self.img_path)
        font = ImageFont.truetype(r"lobster\lobster.ttf", 52)
        d = ImageDraw.Draw(img)
        w, h = d.textsize(self.text, font=font)
        width, heigth = img.size
        center = width / 2 - w / 2
        d.text((center, heigth - 100), self.text, font=font, fill=(255, 255, 255, 255))
        del d
        filename = self.img_path.split("\\")[-1]
        ext = filename.split(".")[-1].upper()
        if not os.path.exists("result"):
            os.mkdir("result")
        path = rf"result\{filename}"
        img.save(path, ext)

        return path
