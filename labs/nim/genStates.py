

tmplF = open('tmpl.html', 'r')
tmpl = tmplF.read()

matchHtml = '<img src="../pic/match.png" class="match">'
linkMatchTmpl = '''
<a href="||link||" class="match">
    <img src="../pic/match.png" class="match">
</a>
'''

for matches in range(21):
    for players in range(2):
        currentTmpl = tmpl
        fileName = 'states/' + str(matches) + '_' + str(players+1) + '.html'
        currentTmpl = currentTmpl.replace('||currentPlayer||', 'Player ' + str(players+1))
        if matches == 0: #end
            currentTmpl = currentTmpl.replace('||matches||', '');
            currentTmpl = currentTmpl.replace('||footerStyle||', 'display: block;')
            currentTmpl = currentTmpl.replace('||winner||', 'Player ' + str(players+1))
            currentTmpl = currentTmpl.replace('||againLink||', '../index.html')
        else: 
            currentTmpl = currentTmpl.replace('||footerStyle||', 'display: none;')

        matchesHtml = ''
        for matchesLeft in range(1,matches+1):
            link = None
            if matchesLeft < 4:
                link = str(matches-matchesLeft) + '_' + str(((players+1) % 2)+1) + '.html'

            if link is None:
                matchesHtml += matchHtml
            else:
                matchesHtml += linkMatchTmpl.replace('||link||', link)

        currentTmpl = currentTmpl.replace('||matches||', matchesHtml)
        f = open(fileName, 'w')
        f.write(currentTmpl)
        f.close()


