#!/Library/Frameworks/Python.framework/Versions/3.7/bin/python3

from invoice2data import extract_data
from invoice2data.extract.loader import read_templates
import json
import sys

file = sys.argv[1]

filename = '/Applications/XAMPP/xamppfiles/htdocs/invoice-app/admin/' + file

templates = read_templates('/Users/krzemson/Desktop/aed/tpl')
result = extract_data(filename, templates=templates)

print(json.dumps(result))


