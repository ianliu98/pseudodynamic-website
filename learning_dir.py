# add/delete or update learning directory
# need refresh button to make sure files are up to date

import os
import random
from datetime import date
from datetime import datetime


def findPositions(line):
    posi_ini = line.find('<')
    posi1 = line.find('>') + 1
    posi2 = line[posi_ini + 1:].find('<') + posi_ini + 1
    return (posi1, posi2)


def sortbyDate(html):
    tmp = 0
    astruct = {}
    dates = []
    atmp = []
    anw = []
    html_nw = []
    for line in html:
        tmp = tmp + 1
        if 'article label' in line:
            atmp.append(tmp - 1)
        if 'time datetime' in line:
            posi = findPositions(line)
            dates_str = line[posi[0]:posi[1]]
            ptime = datetime.strptime(dates_str, "%B %d, %Y").timestamp()
            if ptime in dates:
                ptime = ptime + random.randint(1, 86000)
            dates.append(ptime)
    for i in range(len(dates)):
        astruct[str(dates[i])] = html[atmp[2 * i]:atmp[2 * i + 1] + 1]
    order = sorted(float(j) for j in astruct)  # time order
    order.reverse()
    for i in order:
        anw.extend(astruct[str(i)])
    html_nw = html[:atmp[0]]
    html_nw.extend(anw)
    html_nw.extend(html[atmp[-1] + 1:])
    return html_nw


def contentReplace(article, category_name):
    replace_name = input("Enter the name of substitution: ")
    nname = '../public_html/evernote/' + category_name + '/'+ replace_name + '.html'  # choose from files in GUI
    ncontent = open(nname, 'r', encoding='utf-8').readlines()
    ever_content = ncontent[-2]
    ever_content = ever_content.replace('src="', 'src="../evernote/'+category_name+'/')
#    print(ever_content)

    tmp = 0
    clabel = []
    for line in article:
        tmp = tmp + 1
        if 'datetime=' in line:
            if input("Change date?[Y/N]: ").lower()=='y':
                posi = findPositions(line)
                if input("Use today's date?[Y/N]: ").lower() == 'N'.lower():
                    edate = input("Enter a date with the form like January 01, 2001: ")
                    article[tmp - 1] = line[:posi[0]] + edate + line[posi[1]:]
                else:
                    today = date.today()
                    article[tmp - 1] = line[:posi[0]] + today.strftime("%B %d, %Y") + line[posi[1]:]
        if 'content label' in line:
            clabel.append(tmp - 1)
    seg = article[:clabel[0]+1]
    seg.append(ever_content)
    seg.extend(article[clabel[1]:])
    return seg


def modifyContent(html, category_name):  # delete or replace certain article
    tmp = 0
    astruct = {}
    atitle = []
    atmp = []
    anw = []
    html_nw = []
    for line in html:
        tmp = tmp + 1
        if 'title-learning' in line:
            atitle.append(html[tmp])
        if 'article label' in line:
            atmp.append(tmp - 1)
    atitle_l = [it.lower() for it in atitle]
    for i in range(len(atitle)):
        astruct[atitle_l[i][:-1]] = html[atmp[2 * i]:atmp[2 * i + 1] + 1]
    print("articles: ", astruct.keys())
    choice = input("Delete[D]/Replace[R]: ")
    if choice.lower() == 'd':
        name = input("Enter the title of article: ").lower()
        astruct.pop(name)
    elif choice.lower() == 'r':
        name = input("Enter the title of article: ").lower()
        astruct[name] = contentReplace(astruct[name], category_name)
    for i in astruct.keys():
        anw.extend(astruct[i])
    html_nw = html[:atmp[0]]
    html_nw.extend(anw)
    html_nw.extend(html[atmp[-1] + 1:])
    return html_nw


def addArticle(name, page_name, cname):
    content = open(cname, 'r', encoding='utf-8').readlines()
    apet = 0
    if len(content) <=19:
        ever_content = content[-2]
        ever_content = ever_content.replace('src="', 'src="../evernote/'+name+'/')
    else:
        apet = 1
        ever_content = content[18:-2]
        ever_content = [j.replace('src="', 'src="../evernote/'+name+'/') for j in ever_content]

    seg1 = []
    seg2 = []
    copy_part = []
    seg_tmp = 0
    insert_position = []
    tmp = 0
    alabel = '<!-- article label -->\n'
    for line in open('../public_html/LEARNING/' + name + '.html', 'r', encoding='utf-8').readlines():
        tmp = tmp + 1
        if alabel in line:
            seg_tmp = seg_tmp + 1
            insert_position.append(tmp)
        if seg_tmp == 0:
            seg1.append(line)
        if seg_tmp == 1:
            copy_part.append(line)
        if seg_tmp >= 2:
            seg2.append(line)
    copy_part.append(alabel)
    seg2 = seg2[1:]

    htmp = 0
    for line in seg1:
        htmp = htmp + 1
        if '<base href' in line:
            seg1[htmp - 1] = '\t\t<base href="./' + name + '">\n'

    # modify copy_part here
    nw = copy_part[:]
    tmp = 0
    cposi = []
    for line in nw:
        tmp = tmp + 1
        if 'title-learning' in line:
            template_check = nw[tmp]
            nw[tmp] = page_name + '\n'
        if 'datetime' in line:
            posi = findPositions(line)
            if input("Use today's date?[Y/N]: ").lower() == 'N'.lower():
                edate = input("Enter a date with the form like January 01, 2001: ")
                nw[tmp - 1] = line[:posi[0]] + edate + line[posi[1]:]
            else:
                today = date.today()
                nw[tmp - 1] = line[:posi[0]] + today.strftime("%B %d, %Y") + line[posi[1]:]
        if 'content label' in line:
            cposi.append(tmp)
    nw2 = nw[:cposi[0]]
    if apet==0:
        nw2.append(ever_content)
    else:
        nw2.extend(ever_content)
    nw2.extend(nw[cposi[1] - 1:])

    seg1.extend(nw2)
    if 'template' not in template_check:
        seg1.extend(copy_part)
    seg1.extend(seg2)
    return seg1


def refreshNav(html):
    tmp = 0
    titles = []
    sidebar = []
    anchor = []
    for line in html:
        tmp = tmp + 1
        if 'title-learning' in line:
            titles.append(html[tmp])
        if 'sidebar label' in line:
            sidebar.append(tmp-1)
        if 'anchor' in line:
            anchor.append(tmp-1)
    tmp = 0
    nw_anchor=[]
    for title in titles:
        tmp = tmp + 1
        html[anchor[tmp-1]] = '<a class="anchor" id="post' + str(tmp) + '"></a>\n'
        anchor_tmp = html[sidebar[0]+1:sidebar[0] + 3]
        title = title.strip()
        anchor_tmp[0] = '<p><a href="#post' + str(tmp) + '">' + title.title() + '</a></p>\n'
        nw_anchor.extend(anchor_tmp)
    html_nw = html[:sidebar[0]+1]
    html_nw.extend(nw_anchor)
    html_nw.extend(html[sidebar[1]-1+1:])
    return html_nw


learning_path = '../public_html/LEARNING'
items = os.listdir(learning_path)
print("Categories are: ")
for i in range(len(items)):
    items[i] = items[i][:-5]
    print('[', i, ']', items[i])

dead = input("\n\ndelete[D]/add[A]/modify[M] a category?: ").lower()

if dead=='d':
    dele = items[int(input("Enter label of deleting category: "))]
    if dele in items:
        items.remove(dele)
        os.remove(learning_path + '/' + dele + '.html')
        print(dele, "has been removed!")
    else:  # will not happen in GUI
        print(dele, " is not in the directory!")

elif dead=='a':
    # add new category
    name = input("Enter a new category name: ")  # input from GUI
    tmp = 0
    items_l = [it.lower() for it in items]
    if name.lower() in items_l:
        print(name, " is already in the directory!")
    else:
        template = open('../public_html/templates/Learning-template.html', 'r', encoding='utf-8').readlines()
        tmp = tmp + 1
        ttmp = 0
        for line in template:
            ttmp = ttmp + 1
            if '<base href' in line:
                template[ttmp - 1] = '\t\t<base href="./' + name + '">\n'
            if '<title>' in line:
                posi = findPositions(line)
                template[ttmp - 1] = line[:posi[0]] + name.title() + ' - Ian' + line[posi[1]:]
        open(learning_path + '/' + name + '.html', 'w', encoding='utf-8').writelines(template)
        items.append(name)
        print("Category ", name, " has been created!")

elif dead=='m':
    # name = input("Enter a modifying category name: ")
    name = items[int(input("Enter label of modifying category: "))]

    # operations
    operation = input("Add article[A]/Modify article[M]/Cancel[C]: ").lower()

    if operation=='a':
        # add content
        page_name = input("Enter page name: ")  # title of adding content

        # choose a file here
        filename = input("Enter name of selected file: ")
        cname = '../public_html/evernote/' + name + '/' + filename + '.html'

        seg1 = addArticle(name, page_name, cname)
        seg = sortbyDate(seg1)
        seg = refreshNav(seg)

    elif operation=='m':
        seg = open('../public_html./LEARNING/' + name + '.html', 'r', encoding='utf-8').readlines()
        seg = modifyContent(seg, name)
        seg = sortbyDate(seg)
        seg = refreshNav(seg)

    open(learning_path + '/' + name + '.html', 'w', encoding='utf-8').writelines(seg)
