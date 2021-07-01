# configure memories.html

from PIL import Image
import os


def findPositions(line):
    posi_ini = line.find('<')
    posi1 = line.find('>') + 1
    posi2 = line[posi_ini + 1:].find('<') + posi_ini + 1
    return (posi1, posi2)


imgs = os.listdir('../public_html/memories')

# add new

img_path = '../imgs/202001.jpg'  # choose from certain directory in GUI
img = Image.open(img_path)
img_re = img.resize((1280, 851))
img_name = input("Enter name of the photo(eg. 202001): ")
img_re.save('../public_html/memories/' + img_name + '.jpg', quality=90)
img_title = input("Enter dicription of the photo: ")

lines = open('../public_html/Memories.html', 'r', encoding='utf-8').readlines()
slabel = []
tlabel = []
circle_label = []
dot_label = []
num_label = []
tmp = 0
for line in lines:
    tmp = tmp + 1
    if 'slide label' in line:
        slabel.append(tmp - 1)
    if 'thumbnail label' in line:
        tlabel.append(tmp - 1)
    if 'circles label' in line:
        circle_label.append(tmp - 1)
    if 'dots label' in line:
        dot_label.append(tmp - 1)
    if 'numbers label' in line:
        num_label.append(tmp - 1)
img_names = []
img_titles = []
for i in range(len(slabel) // 2):
    for line in lines[slabel[2 * i]:slabel[2 * i + 1]]:
        if 'data-src' in line:
            img_names.append(line[24:-2])
        if 'class="title' in line:
            posi = findPositions(line)
            img_titles.append(line[posi[0]:posi[1]])

slidestruc = {}
thumbstruc = {}
titlestruc = {}
tmp = 0
for i in img_names:
    tmp = tmp + 1
    slidestruc[i] = lines[slabel[2 * (tmp - 1)]:slabel[2 * (tmp - 1) + 1] + 1]
    thumbstruc[i] = lines[tlabel[2 * (tmp - 1)]:tlabel[2 * (tmp - 1) + 1] + 1]
    titlestruc[i] = img_titles[tmp - 1]

print(imgs)
if input("Do you want to delete one of them? [Y/N]: ").lower() == 'y':
    delete = input("Enter the name of the image: ")
    slidestruc.pop(delete + '.jpg')
    thumbstruc.pop(delete + '.jpg')
    titlestruc.pop(delete + '.jpg')
    os.remove('../public_html/memories/' + delete + '.jpg')

sbody = lines[slabel[0]:slabel[1] + 1]
tbody = lines[tlabel[0]:tlabel[1] + 1]
tmp = 0
for line in sbody:
    tmp = tmp + 1
    if 'data-src' in line:
        sbody[tmp - 1] = '<img data-src="memories/' + img_name + '.jpg"\n'
    if 'data-image=' in line:
        sbody[tmp - 1] = '  data-image="memories/' + img_name + '.jpg"\n'
    if 'jpg">' in line:
        sbody[tmp - 1] = '  src="memories/' + img_name + '.jpg">\n'
    if 'class="title"' in line:
        sbody[tmp - 1] = '  <p class="title">' + img_title + '</p>\n'
tmp = 0
for line in tbody:
    tmp = tmp + 1
    if 'data-src' in line:
        tbody[tmp - 1] = '<img data-src="memories/' + img_name + '.jpg"\n'
    if 'data-image=' in line:
        tbody[tmp - 1] = '  data-image="memories/' + img_name + '.jpg"\n'

slidestruc[img_name + '.jpg'] = sbody
thumbstruc[img_name + '.jpg'] = tbody
titlestruc[img_name + '.jpg'] = img_title
order = sorted(slidestruc)
order.reverse()

seg1 = lines[:slabel[0]]
seg2 = []
for item in order:
    seg2.extend(slidestruc[item])  # begin with slide label
seg3 = lines[slabel[-1] + 1:circle_label[0] + 1]  # begin and end with labels
seg4 = []
seg4.extend('<div class="circles gallery-nav">\n')  # no label
for i in range(len(order)):
    seg4.extend('  <span class="circle"></span>\n')
seg4.extend('</div>\n')
seg5 = lines[circle_label[-1]:dot_label[0] + 1]  # begin and end with labels
seg6 = []
seg6.extend('<div class="dots gallery-nav">\n')
for i in range(len(order)):
    seg6.extend('  <span class="dot"></span>\n')
seg6.extend('</div>\n')
seg7 = lines[dot_label[-1]:num_label[0] + 1]  # begin and end with labels
seg8 = []
seg8.extend('<div class="numbers gallery-nav">\n')
for i in range(len(order)):
    seg8.extend('  <span class="number">' + str(i + 1) + '</span>\n')
seg8.extend('</div>\n')
seg9 = lines[num_label[-1]:tlabel[0]]
seg10 = []
for item in order:
    seg10.extend(thumbstruc[item])
seg11 = lines[tlabel[-1] + 1:]

seg1.extend(seg2)
seg1.extend(seg3)
seg1.extend(seg4)
seg1.extend(seg5)
seg1.extend(seg6)
seg1.extend(seg7)
seg1.extend(seg8)
seg1.extend(seg9)
seg1.extend(seg10)
seg1.extend(seg11)

open('../public_html/memories.html', 'w', encoding='utf-8').writelines(seg1)
