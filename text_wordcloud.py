import sys
import nltk
from nltk.corpus import stopwords 
import re
from string import punctuation as p
from collections import Counter

# text is a list split at spaces
# containing punctuation and \\n and has not been lowercased
text = sys.argv[1:]

punctuation = re.compile('[{}]+'.format(re.escape(p)))

correct_text = []
for word in text:
	word = word.lower()
	if '\\n' in word:
		word_list = word.split('\\n')
		correct_text.extend(word_list)
	else:
		correct_text.append(word)
		
# correct_text now has no \\n and is lowercased
correct_text = ' '.join(correct_text)
# now all remaining punctuation is removed
correct_text = punctuation.sub('', correct_text)
correct_text = correct_text.split()

stops = set(stopwords.words('english'))
# we add stopwords that are common to songs
stops2 = set(['ah', 'oh', 'mm', 'yeah', 'youre', 'thats', 'aint', 'id', 'dont', 'youd', 'theres', 'cant'])
stops = stops | stops2

correct_text_2 = []
for word in correct_text:
	if word not in stops:
		correct_text_2.append(word)

# correct_text_2 has no stopwords 
# and is a clean list of all words in the lyrics

c = Counter(correct_text_2)

list = []
for word in c:
	list.append([word, c[word]*10]) 
	
print (list)




