# configure essay.html

import os
import math
from datetime import datetime
import random


def findPositions(line):
    posi_ini = line.find('<')
    posi1 = line.find('>') + 1
    posi2 = line[posi_ini + 1:].find('<') + posi_ini + 1
    return (posi1, posi2)


def titleDate(item):
    essay_path = '../public_html/ESSAY'
    tmp = 0
    once = 0
    pposi = []
    lines = open(essay_path + '/' + item, 'r', encoding='utf-8').readlines()
    for line in lines:
        tmp = tmp + 1
        if 'POST TITLE' in line:
            ptitle = lines[tmp + 1]
        if 'POST DATE' in line:
            posi = findPositions(lines[tmp + 1])
            pdate = lines[tmp + 1][posi[0]:posi[1]]
        if 'article label' in line:
            pposi.append(tmp - 1)
            once = once + 1
        if once >= 2:
            break
    pcontent = lines[pposi[0]:pposi[1] + 1]
    tmp = 0
    for line in pcontent:
        tmp = tmp + 1
        if 'POST TITLE' in line:
            pcontent[tmp + 1] = '<a href="ESSAY/' + item[:-5] + '">' + ptitle.strip() + '</a>\n'
    return (ptitle, pdate, pcontent)


essay_path = '../public_html/ESSAY'
fpath = '../public/Essay.html'
essays = os.listdir(essay_path)
essays_tit = {}
essays_dat = {}
essays_con = {}
time_array = []
for item in essays:
    [ptitle, pdate, pcontent] = titleDate(item)
    ptime = datetime.strptime(pdate, "%B %d, %Y").timestamp()
    time_array.append(ptime)
    if ptime in time_array:
        ptime = ptime + random.randint(1, 86000)
    essays_tit[str(ptime)] = ptitle
    essays_dat[str(ptime)] = pdate
    essays_con[str(ptime)] = pcontent
order = sorted(float(i) for i in essays_tit)  # time order
order.reverse()

# for odr in order:
#     print(essays_tit[str(odr)])

htmls = os.listdir('../public_html')
for html in htmls:
    if 'Essay-page' in html:
        os.remove('../public_html/' + html)

num = 3  # number of essays per page
page_num = math.ceil(len(essays) / num)

template = open('../public_html/Essay-template.html', 'r', encoding='utf-8').readlines()
tmp = 0
once = 0
alabel = []
for line in template:
    tmp = tmp + 1
    if 'article label' in line:
        alabel.append(tmp - 1)
        once = once + 1
    if once >= 2:
        break
seg1 = template[:alabel[0]]  # no article label
seg2 = template[alabel[1] + 1:]

fname = []
for i in range(1, page_num + 1):
    head = seg1[:]
    foot = seg2[:]
    body = []
    if i == 1:
        fname.append('Essay.html')
        if page_num == 1:
            tmp = 0
            for line in foot:
                tmp = tmp + 1
                if 'NEWER PAGE' in line:
                    foot[tmp] = '\t\t\t\t<span class="disabled next">\n'
                    foot[tmp + 1] = '→\n'

    elif i == page_num:
        fname.append('Essay-page' + str(i) + '.html')
        tmp = 0
        for line in foot:
            tmp = tmp + 1
            if 'OLDER PAGE' in line:
                foot[tmp] = '\t\t\t\t<span class="prev">\n'
                foot[tmp + 1] = '<a href="./' + 'Essay-page' + str(i - 1) + '">←</a>\n'
            if 'NEWER PAGE' in line:
                foot[tmp] = '\t\t\t\t<span class="disabled next">\n'
                foot[tmp + 1] = '→\n'
    else:
        fname.append('Essay-page' + str(i) + '.html')
        tmp = 0
        for line in foot:
            tmp = tmp + 1
            if 'OLDER PAGE' in line:
                foot[tmp] = '\t\t\t\t<span class="prev">\n'
                if i == 2:
                    foot[tmp + 1] = '<a href="./Essay">←</a>\n'
                else:
                    foot[tmp + 1] = '<a href="./' + 'Essay-page' + str(i - 1) + '">←</a>\n'
            if 'NEWER PAGE' in line:
                foot[tmp] = '\t\t\t\t<span class="next">\n'
                foot[tmp + 1] = '<a href="./' + 'Essay-page' + str(i + 1) + '">→</a>\n'

    if i != page_num or len(essays) % num == 0:  # not last page
        for j in range(num * (i - 1), num * i):
            body.extend(essays_con[str(order[j])])
    else:
        for j in range(num * (i - 1), len(essays) % num + num * (i - 1)):
            body.extend(essays_con[str(order[j])])
    htmp = 0
    for line in head:
        htmp = htmp + 1
        if '<base href' in line:
            head[htmp - 1] = '\t\t<base href="./' + fname[i - 1][:-5] + '">\n'
    head.extend(body)
    head.extend(foot)
    open('../public_html/' + fname[i - 1], 'w', encoding='utf-8').writelines(head)