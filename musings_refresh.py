# configure musing.html

from datetime import datetime
from datetime import date

def findPositions(line):
    posi_ini = line.find('<')
    posi1 = line.find('>') + 1
    posi2 = line[posi_ini+1:].find('<') + posi_ini + 1
    return (posi1, posi2)

lines = open('../public_html/Musings.html','r',encoding='utf-8').readlines()
tmp = 0
plabel = []
for line in lines:
    tmp = tmp + 1
    if 'post label' in line:
        plabel.append(tmp-1)

dates = []
contents = []
for i in range(len(plabel)//2):
    tmp = 0
    for line in lines[plabel[2*i]:plabel[2*i+1]]:
        tmp = tmp + 1
        if 'datetime' in line:
            posi = findPositions(line)
            dates.append(datetime.strptime(line[posi[0]:posi[1]], "%B %d, %Y").timestamp())
        if 'text-align-center' in line:
            contents.append(lines[plabel[2*i]+tmp])

cstruct = {}
sstruct = {}
for i in range(len(dates)):
    cstruct[str(dates[i])] = contents[i]
    sstruct[str(dates[i])] = lines[plabel[2*i]:plabel[2*i+1]+1]

# delete
print(cstruct)
if input("Do you want to delete one of them?[Y/N]: ").lower()=='y':
    delete = input("Enter the date: ")
    cstruct.pop(delete)
    sstruct.pop(delete)
    body = []
    for item in sstruct:
        body.extend(sstruct[str(item)])

if input("Add a musing?[Y/N]: ").lower() == 'y':
    # add
    mbody = lines[plabel[0]:plabel[1]+1]
    tmp = 0
    for line in mbody:
        tmp = tmp + 1
        if 'datetime' in line:
            if input("Use today's date?[Y/N]: ").lower()=='n':
                mdate = input("Enter a date with the form like January 01, 2001: ")  # choose from GUI can avoid mistake of typing
            else:
                mdate_tmp = date.today()
                mdate = mdate_tmp.strftime("%B %d, %Y")
            mbody[tmp-1] = '    <time datetime="2021-06-07">' + mdate + '</time>\n'
        if 'text-align-center' in line:
            musing = input("Input your musing: ")
            mbody[tmp] = musing
    date_num = datetime.strptime(mdate, "%B %d, %Y").timestamp()
    cstruct[str(date_num)] = musing
    sstruct[str(date_num)] = mbody

    order = sorted([float(i) for i in sstruct])
    order.reverse()

    body = []
    for item in order:
        body.extend(sstruct[str(item)])

head = lines[:plabel[0]]
foot = lines[plabel[-1]+1:]

head.extend(body)
head.extend(foot)


open('../public_html/Musings.html','w',encoding='utf-8').writelines(head)