#!/usr/bin/env python3
from glob import iglob
# Requires python-imaging package!
from PIL import Image

def get_image_size(filename):
    return Image.open(filename).size

print("var galleryItems = [")
lista = [element for element in iglob("*.jpg")]
lista = sorted(lista)
for i, element in enumerate(lista):
    width, height = get_image_size(element)
    print("{src: 'slideshow/" + element + "', w: " + str(width) + ", h: " + str(height) + "}", end="")
    if i == len(lista) - 1: continue
    print(",")
print("]")
