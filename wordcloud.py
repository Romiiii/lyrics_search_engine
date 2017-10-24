import sys
from pytagcloud import create_tag_image, make_tags
from pytagcloud.lang.counter import get_tag_counts
import nltk
from nltk.corpus import stopwords 
import re
from string import punctuation as p
#print ('entered python')
i = sys.argv[1]
print('index is', i)
text = sys.argv[2:]


'''
#print (text)
#print ('length is', len(sys.argv))
#print(sys.argv[2])
#text = text.replace('\n', ' ')

punctuation = re.compile('[{}]+'.format(re.escape(p)))


correct_text = []
for word in text:
	word = word.lower()
	if '\\n' in word:
		word_list = word.split('\\n')
		correct_text.extend(word_list)
	else:
		correct_text.append(word)
		
#print("after replace")
#print ("after split:", correct_text)

correct_text = ' '.join(correct_text)
correct_text = punctuation.sub('', correct_text)
correct_text = correct_text.split()
stops = set(stopwords.words('english'))

stops2 = set(['ah', 'oh', 'mm', 'yeah', 'youre', 'thats'])

stops = stops | stops2

correct_text_2 = []
for word in correct_text:
	if word not in stops:
		correct_text_2.append(word)

correct_text_2 = ' '.join(correct_text_2)
#print("after punct", correct_text_2)


tags = make_tags(get_tag_counts(correct_text_2), maxsize=200)
#print (tags)
#print("after tags")
file_name = 'cloud_' + i + '.png'
create_tag_image(tags, file_name, size=(600,600), fontname='Lobster', rectangular=True)
'''