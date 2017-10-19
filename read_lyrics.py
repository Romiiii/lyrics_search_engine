from elasticsearch import helpers, Elasticsearch
import csv

print("Hello world met billboard")
es = Elasticsearch()
with open('billboard_lyrics_1964-2015_year.csv') as f:
    reader=csv.DictReader(f)
    helpers.bulk(es, reader, index='my-index', doc_type='my-type')