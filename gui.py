import tkinter as tk
from tkinter import ttk
from tkinter import Menu
from tkinter import simpledialog

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

#   --> refresh
learning_category_refresh = ttk.Button(learning, text="category refresh")
learning_category_refresh.grid(column=2, row=3, columnspan=2)
#   --> add category
learning_add_category = ttk.Button(learning, text="Add Category", command=categoryName)
learning_add_category.grid(column=2, row=4, columnspan=2)

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
learning_contents_refresh = ttk.Button(learning, text="content refresh")
learning_contents_refresh.grid(column=5, row=3, columnspan=2)
#   --> add content
learning_add_content = ttk.Button(learning, text="Add Content")
learning_add_content.grid(column=5, row=4, columnspan=2)


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

win.mainloop()