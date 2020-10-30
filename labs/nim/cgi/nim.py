#!/usr/bin/python3

import os

print('Content-Type: text/html')
print('')


query = os.environ['QUERY_STRING']

indexF = open('../nim-static/index-cgi.html', 'r')
index = indexF.read()
indexF.close()

tmplF = open('../nim-static/tmpl-cgi.html', 'r')
tmpl = tmplF.read()
tmplF.close()

matchHtml = '<img src="../nim-static/pic/match.png" class="match">'
linkMatchTmpl = '''
<a href="||link||" class="match">
    <img src="../nim-static/pic/match.png" class="match">
</a>
'''

if len(query) == 0:
    print(index)
    exit()

queryParams = query.split('&')

if len(queryParams) < 2:
    print('invalid params')
    exit()

matchesParam = queryParams[0].split('=')
if len(matchesParam) < 2:
    print('invalid params')
    exit()

matches = int(matchesParam[1])

playerParam = queryParams[1].split('=')
if len(matchesParam) < 2:
    print('invalid params')
    exit()
currentPlayer = int(playerParam[1])

if (matches == '') or (currentPlayer == ''):
    print('params error')
    exit()

currentTmpl = tmpl
currentTmpl = currentTmpl.replace('||currentPlayer||', 'Player ' + str(currentPlayer+1))
if matches == 0: #end
    currentTmpl = currentTmpl.replace('||matches||', '');
    currentTmpl = currentTmpl.replace('||footerStyle||', 'display: block;')
    currentTmpl = currentTmpl.replace('||winner||', 'Player ' + str(currentPlayer+1))
    currentTmpl = currentTmpl.replace('||againLink||', '/~oupickyj/cgi-bin/nim.py')
else: 
    currentTmpl = currentTmpl.replace('||footerStyle||', 'display: none;')

matchesHtml = ''
for matchesLeft in range(1,matches+1):
    link = None
    if matchesLeft < 4:
        link = '?m=' + str(matches-matchesLeft) + '&p=' + str(((currentPlayer+1) % 2))

    if link is None:
        matchesHtml += matchHtml
    else:
        matchesHtml += linkMatchTmpl.replace('||link||', link)

currentTmpl = currentTmpl.replace('||matches||', matchesHtml)
print(currentTmpl)
