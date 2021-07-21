# --------------------------------------------
import tkinter as tk
from tkinter import ttk
from tkinter import Menu
from tkinter import simpledialog
from tkinter import Tk
from tkinter.filedialog import askopenfilename
from tkcalendar import Calendar
import os
from datetime import date
# --------------------------------------------

# --------------------------------------------
DATE = date.today()

# --------------------------------------------

win = tk.Tk()
win.title("ianliu98.com modifier")
win.resizable(1, 1)

# add tabs
tabControl = ttk.Notebook(win)
tab1 = ttk.Frame(tabControl)
tabControl.add(tab1, text='Html')
tab2 = ttk.Frame(tabControl)
tabControl.add(tab2, text='CSS')
tabControl.pack(expand=1, fill="both")

# add frames
about = ttk.LabelFrame(tab1, text='About')
about.grid(column=0, row=0, padx=8, pady=8, sticky='WENS')
learning = ttk.LabelFrame(tab1, text='Learning')
learning.grid(column=2, row=0, padx=8, pady=8, sticky='WENS')
essay = ttk.LabelFrame(tab1, text='Essays')
essay.grid(column=7, row=0, padx=8, pady=8, sticky='WENS')


#######################
# call-back functions #
#######################
# about
def aboutContentPreview():
    about_content_preview.configure(text='modify later!')


def categoryName():
    new_category = simpledialog.askstring("Input", "Enter a category name: ", parent=win)


def categoryMenu(event):
    learning_category_list_node.select_clear(0, tk.END)  # let right click select the event
    learning_category_list_node.select_set(learning_category_list_node.nearest(event.y))
    learning_category_list_node.activate(learning_category_list_node.nearest(event.y))
    try:  # pop out menu
        category_menu.tk_popup(event.x_root, event.y_root)
    finally:
        category_menu.grab_release()


def contentMenu(event):
    learning_contents_list_node.select_clear(0, tk.END)  # let right click select the event
    learning_contents_list_node.select_set(learning_contents_list_node.nearest(event.y))
    learning_contents_list_node.activate(learning_contents_list_node.nearest(event.y))
    try:  # pop out menu
        content_menu.tk_popup(event.x_root, event.y_root)
    finally:
        content_menu.grab_release()


def essayMenu(event):
    essay_list_node.select_clear(0, tk.END)  # let right click select the event
    essay_list_node.select_set(essay_list_node.nearest(event.y))
    essay_list_node.activate(essay_list_node.nearest(event.y))
    try:  # pop out menu
        essay_menu.tk_popup(event.x_root, event.y_root)
    finally:
        essay_menu.grab_release()


def plusWindow():
    global DATE
    plus_window = tk.Toplevel(win)
    plus_window.title('Add a New File')
    plus_window.resizable(0, 0)

    def chooseFile():
        file_chose = Tk()
        file_chose.withdraw()
        file_path = askopenfilename(initialdir=os.getcwd(), title='Choose a file', filetypes=[('html files', '.html')])
        new_path.config(text=os.path.split(file_path)[-1])
    new_button = ttk.Button(plus_window, text="Select a file:", command=chooseFile)
    new_button.grid(column=0, row=0, columnspan=2)
    new_path = ttk.Label(plus_window, text="")
    new_path.grid(column=3, row=0, columnspan=2)

    def fileName():
        tmp = simpledialog.askstring("Input", "Enter a new name: ", parent=plus_window)
        new_name_input.config(text=tmp)
    new_name = ttk.Button(plus_window, text="Input a name:", command=fileName)
    new_name.grid(column=0, row=1, columnspan=2)
    new_name_input = ttk.Label(plus_window, width=12, text="")
    new_name_input.grid(column=3, row=1, columnspan=2)

    cal = Calendar(plus_window, selectmode='day', year=DATE.year, month=DATE.month, day=DATE.day)
    cal.grid(column=0, row=3, columnspan=5)

    def grad_date():
        date.config(text=cal.get_date())
    date_label = ttk.Button(plus_window, text="Choose a date:", command=grad_date)
    date_label.grid(column=0, row=2, columnspan=2)
    date = ttk.Label(plus_window, text="")
    date.grid(column=3, row=2, columnspan=2)

# Exit
def _quit():
    win.quit()
    win.destroy()
    exit()


##########
# frames #
##########
# about frame
# --> content
about_content = ttk.LabelFrame(about, text='Content')
about_content.grid(column=0, row=0)
#    --> preview
about_content_preview = ttk.Button(about_content, text="preview", command=aboutContentPreview)
about_content_preview.grid(column=0, row=0)
#    --> replace
about_content_replace = ttk.Button(about_content, text="replace")
about_content_replace.grid(column=0, row=1)
#   --> modify
about_content_modify = ttk.Button(about_content, text="modify")
about_content_modify.grid(column=0, row=2)

# --> profile
about_profile = ttk.LabelFrame(about, text='Profile')
about_profile.grid(column=1, row=0)
#   --> preview
about_profile_preview = ttk.Button(about_profile, text="preview")
about_profile_preview.grid(column=1, row=0)
#   --> replace
about_profile_replace = ttk.Button(about_profile, text="replace")
about_profile_replace.grid(column=1, row=1)


# learning frame
# --> categories
#   --> list frame
learning_category_list = tk.Frame(learning)
learning_category_list.grid(column=2, row=0, columnspan=2, rowspan=3)
#     --> list nodes
learning_category_list_node = tk.Listbox(learning_category_list, width=10, height=5)
learning_category_list_node.pack(side="left", fill="y")
learning_category_list_scrollbar = tk.Scrollbar(learning_category_list)
learning_category_list_scrollbar.config(command=learning_category_list_node.yview)
learning_category_list_scrollbar.pack(side="right", fill="y")
learning_category_list_node.config(yscrollcommand=learning_category_list_scrollbar.set)
learning_category_list_node.insert(1, 'test1')
learning_category_list_node.insert(2, 'test2')
learning_category_list_node.insert(3, 'test3')
learning_category_list_node.insert(4, 'test4')
learning_category_list_node.insert(5, 'test5')
learning_category_list_node.insert(6, 'test6')
learning_category_list_node.insert(7, 'test7')
learning_category_list_node.insert(8, 'test8')
learning_category_list_node.insert(9, 'test9')
#       --> bind right-click
learning_category_list_node.bind('<Button-3>', categoryMenu)

refresh_icon = tk.PhotoImage(file=r"symbols\refresh.png")
refresh_icon_resize = refresh_icon.subsample(12, 12)
plus_icon = tk.PhotoImage(file=r"symbols\plus.png")
plus_icon_resize = plus_icon.subsample(12, 12)

#   --> refresh
learning_category_refresh = ttk.Button(learning, image=refresh_icon_resize)
learning_category_refresh.grid(column=2, row=3)
#   --> add category
learning_add_category = ttk.Button(learning, image=plus_icon_resize, command=categoryName)
learning_add_category.grid(column=3, row=3)

# --> right arrow
right_arrow = ttk.Label(learning, text=u'{unicodes_value}'.format(unicodes_value='\u27A9'))
right_arrow.grid(column=4, row=1)

# --> contents
#   --> list frame
learning_contents_list = tk.Frame(learning)
learning_contents_list.grid(column=5, row=0, columnspan=2, rowspan=3)
#     --> list nodes
learning_contents_list_node = tk.Listbox(learning_contents_list, width=10, height=5)
learning_contents_list_node.pack(side="left", fill="y")
learning_contents_list_scrollbar = tk.Scrollbar(learning_contents_list)
learning_contents_list_scrollbar.config(command=learning_contents_list_node.yview)
learning_contents_list_scrollbar.pack(side="right", fill="y")
learning_contents_list_node.config(yscrollcommand=learning_contents_list_scrollbar.set)
learning_contents_list_node.insert(1, 'content1')
#       --> bind right-click
learning_contents_list_node.bind('<Button-3>', contentMenu)

#   --> refresh
learning_contents_refresh = ttk.Button(learning, image=refresh_icon_resize)
learning_contents_refresh.grid(column=5, row=3)
#   --> add content
learning_add_content = ttk.Button(learning, image=plus_icon_resize, command=plusWindow)
learning_add_content.grid(column=6, row=3)


# Essay frame
essay_list = tk.Frame(essay)
essay_list.grid(column=7, row=0, rowspan=4)
essay_list_node = tk.Listbox(essay_list, width=10, height=7)
essay_list_node.pack(side="left", fill="y")
essay_list_scrollbar = tk.Scrollbar(essay_list)
essay_list_scrollbar.config(command=essay_list_node.yview)
essay_list_scrollbar.pack(side="right", fill="y")
essay_list_node.config(yscrollcommand=essay_list_scrollbar.set)
essay_list_node.insert(1, 'hello')
essay_list_node.insert(2, 'yes')
essay_list_node.insert(3, 'what')
essay_list_node.bind('<Button-3>', essayMenu)

essay_refresh = ttk.Button(essay, image=refresh_icon_resize)
essay_refresh.grid(column=9, row=1)
essay_add = ttk.Button(essay, image=plus_icon_resize, command=plusWindow)
essay_add.grid(column=9, row=3)



#########
# menus #
#########
# main menu
menu_bar = Menu(win)
win.config(menu=menu_bar)
# --> file
file_menu = Menu(menu_bar, tearoff=0)
file_menu.add_command(label="View Webpage")
file_menu.add_separator()
file_menu.add_command(label="Exit", command=_quit)
menu_bar.add_cascade(label="File", menu=file_menu)
# --> help
help_menu = Menu(menu_bar, tearoff=0)
help_menu.add_command(label="About")
menu_bar.add_cascade(label="Help", menu=help_menu)

# category menu
category_menu = Menu(learning_category_list_node, tearoff=0)
category_menu.add_command(label="Excerpt")
category_menu.add_command(label="Contents")
category_menu.add_command(label="Rename")
category_menu.add_command(label="Remove")

# content menu
content_menu = Menu(learning_contents_list_node, tearoff=0)
content_menu.add_command(label="Preview")
content_menu.add_command(label="Modify")
content_menu.add_command(label="Rename")
content_menu.add_command(label="Remove")

# essay menu
essay_menu = Menu(essay_list_node, tearoff=0)
essay_menu.add_command(label="Preview")
essay_menu.add_command(label="Modify")
essay_menu.add_command(label="Replace")
essay_menu.add_command(label="Rename")
essay_menu.add_command(label="Remove")

win.mainloop()