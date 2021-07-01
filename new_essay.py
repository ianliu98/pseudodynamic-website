# add new essay

from datetime import date

def findPositions(line):
    posi_ini = line.find('<')
    posi1 = line.find('>') + 1
    posi2 = line[posi_ini+1:].find('<') + posi_ini + 1
    return (posi1, posi2)


name = input("Enter name of new essay: ")
essay_path = '../public_html/ESSAY'

lines = open('../public_html/templates/Essay-single-template.html','r',encoding='utf-8').readlines()

tmp = 0
once = 0
cposi = []
for line in lines:
    tmp = tmp + 1
    if '<base href' in line:
            lines[tmp-1] = '\t\t<base href="./' + name + '">\n'
    if '<title>' in line:
        posi = findPositions(line)
        lines[tmp-1] = line[:posi[0]] + name.title() + ' - Ian' + line[posi[1]:]
    if 'POST TITLE' in line:
        lines[tmp+1] = name + '\n'
    if 'datetime' in line:
        posi = findPositions(line)
        if input("Use today's date?[Y/N]: ").lower()=='N'.lower():
            edate = input("Enter a date with the form like January 01, 2001: ")  # choose from GUI can avoid mistake of typing
            lines[tmp-1] = line[:posi[0]] + edate + line[posi[1]:]
        else:
            edate = date.today()
            lines[tmp-1] = line[:posi[0]] + edate.strftime("%B %d, %Y") + line[posi[1]:]
    if 'content label' in line:
        cposi.append(tmp-1)
        once = once + 1
    if once >= 2:
        break

cname = '../public_html/markdown-html/to_Holden.html'  # choose from files in GUI
content = open(cname,'r',encoding='utf-8').readlines()
new = lines[:cposi[0]+1]
new.extend(content[1:-1])
new.extend(lines[cposi[1]:])

open(essay_path+'/'+name+'.html','w',encoding='utf-8').writelines(new)