from elasticsearch import helpers, Elasticsearch
import csv

es = Elasticsearch()

with open('billboard_lyrics_1964-2015_year.csv', encoding='latin-1') as f:
    reader=csv.DictReader(f)
    helpers.bulk(es, reader, index='my-index', doc_type='my-type')