# Refresh items in Learning.html

from os import listdir
import re
from datetime import datetime


def findPositions(line):  # find positions of > extraction <
    posi_ini = line.find('<')
    posi1 = line.find('>') + 1
    posi2 = line[posi_ini + 1:].find('<') + posi_ini + 1
    return (posi1, posi2)


def excerptFrom(item):  # create excerpt
    item_path = '../public_html/LEARNING/' + item + '.html'
    lines = open(item_path, 'r', encoding='utf-8').readlines()
    tmp = 0
    label = []
    cnt = 0
    for line in lines:
        tmp = tmp + 1
        if 'content label' in line:
            cnt = cnt + 1
            label.append(tmp)
    content = lines[label[0]:label[1]]
    string = ''
    for line in content:
        while re.search('<.*?>', line):  # string regular expression -> find format '< >'
            line = line.replace(re.search('<.*?>', line).group(0), '')
        string = string + line
    return (string[:200], cnt / 2)  # length of excerption & number of pages in current catogory


def exportDate(item):
    item_path = '../public_html/LEARNING/' + item + '.html'
    lines = open(item_path, 'r', encoding='utf-8').readlines()
    tmp = 0
    once = 0
    for line in lines:
        tmp = tmp + 1
        if 'datetime' in line and once == 0:
            date_posi = findPositions(lines[tmp-1])
            date = lines[tmp-1][date_posi[0]:date_posi[1]]
            once = once + 1
    return date


fpath = '../public_html/Learning.html'
label_title = 'LEARNING/'
label_content = 'learning-excerpt'
file = open(fpath, 'r', encoding='utf-8').readlines()

# traversal -> list current items
segment = {}
parts = {}
title = []
content = []
line_label = []
tmp = 0
for line in file:
    tmp = tmp + 1
    if label_title in line:
        line_label.append(tmp)
        [posi1, posi2] = findPositions(line)
        title.append(line[posi1:posi2])
    if label_content in line:
        [posi1, posi2] = findPositions(file[tmp])
        content.append(file[tmp][posi1:posi2])

for i in range(len(title)):
    segment[title[i]] = content[i]
    parts[title[i]] = file[line_label[i] - 2:line_label[i] + 4]

title_format = file[line_label[0] - 4:line_label[0] + 1]
content_format = file[line_label[0] + 1:line_label[0] + 6]

# refreshing  -->  check if any update exists in LEARNING directory
learning_path = '../public_html/LEARNING'
files = listdir(learning_path)

for i in title:  # remove extra
    if i + '.html' not in files:
        segment.pop(i)
        parts.pop(i)

ptimes = []
for i in range(len(files)):
    item_d = files[i][:-5]
    if item_d not in title:
        title.append(item_d)
    date = exportDate(item_d)
    ptime = datetime.strptime(date, "%B %d, %Y").timestamp()
    ptimes.append(ptime)
new_posi = ptimes.index(max(ptimes))

for i in range(len(files)):  # refresh
    item = files[i][:-5]
    if item not in title:
        title.append(item)
    [excerpt, pnum] = excerptFrom(item)
    excerpt = excerpt[:excerpt.rfind(' ')].strip() + ' ...'
    excerpt = excerpt.replace('\n', ' ')
    title_nw = title_format[:]
    content_nw = content_format[:]
    posi_ini = title_nw[3].find('<')
    if i == new_posi:
        suffix = ')     <i><b style="color:red;font-size:30px;">New!</b></i>'
    else:
        suffix = ')'
    title_nw[3] = title_nw[3][:posi_ini] + '<a href="LEARNING/' + item + '">' + item + '(' + str(
        int(pnum)) + suffix + '</a>\n'
    [posi1, posi2] = findPositions(content_nw[1])
    segment[item] = excerpt
    content_nw[1] = content_nw[1][:posi1] + excerpt + content_nw[1][posi2:]
    title_nw.extend(content_nw)
    parts[item] = title_nw

head = file[:line_label[0] - 4]
foot = file[line_label[-1] + 6:]
body = []

for i in sorted(segment, key=str.casefold):
    body.extend(parts[i])

head.extend(body)
head.extend(foot)
path_test = '../public_html/learning.html'
open(path_test, 'w', encoding='utf-8').writelines(head)