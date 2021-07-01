# Replace content in about.html

fname = '../public_html/About.html'
label = '<!-- content label -->\n'
file = open(fname,'r',encoding='utf-8')
switch = 0
tmp = 0
segment = {}
seg_label = 0
once = 1
name = []
for line in file.readlines():
    tmp = tmp + 1
    if switch%2==0:
        if once==1:
            seg_label = seg_label + 1
            name.append("seg"+str(seg_label))
            segment[name[seg_label-1]] = []
            if switch!=0:
                segment[name[seg_label-1]].append(label)
            once = 0
        segment[name[seg_label-1]].append(line)
    if line==label:
        switch = switch +1
        once = 1

cname = '../public_html/markdown-html/personal_statement.html'
content = open(cname,'r',encoding='utf-8').readlines()
new = segment[name[0]]
new.extend(content[1:-1])
new.extend(segment[name[1]])

file.close()

file = open(fname, 'w', encoding='utf-8')
file.writelines(new)

file.close()