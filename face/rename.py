import os

i = 1
for file in os.listdir('.'):    #os.listdir('.')遍历文件夹内的每个文件名，并返回一个包含文件名的list
    if file[-2: ] == 'py':
        continue   #过滤掉改名的.py文件
    name = file.replace(' ', '')   #去掉空格
    #print(file)
    new_name = 'zface_'+str(i)+'.png'
    print(name+'->'+new_name)
    os.rename(file, new_name)
    i += 1