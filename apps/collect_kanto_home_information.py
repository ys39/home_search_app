#!/usr/bin/env python
# coding: utf-8

import sys
import re
import time
import urllib2
import requests
import codecs
import json
from bs4 import BeautifulSoup

### Set Suumo URL + Search Word
#########################

Gid = 1;
Gid2 = 1;
resultjson = []
traffic_array = []
page_num_init = 1
page_num_last = 1000
# suumoは10万件超過のデータへアクセスできない
for page_num in range(page_num_init, page_num_last):

  search_word = "."
  display_num = "100"
  #page_num = "1"
  fqdn = "https://suumo.jp"
  url = fqdn + "/jj/chintai/ichiran/FR301FC011/?ar=030&bs=040&fw=" + search_word + "&pc=" + display_num + "&page=" + str(page_num)

  req=requests.get(url)
  soup = BeautifulSoup(req.text.encode(req.encoding), "html.parser")

  ### Get Home Information
  #########################
  soup1 = soup.find_all(class_ = "js-cassetLinkHref")

  # rent
  soup2 = soup.find_all(class_ = "detailbox-property-point")
  rent_array = []
  for idx, val in enumerate(soup2):
   rent_array.append(val.text)

  # kind, age, address
  soup3 = soup.find_all(class_ = "detailbox-property-col")
  kind_array = []
  age_array = []
  address_array = []
  for idx, val in enumerate(soup3):
    if idx % 5 == 0:
      # rent
      pass
    elif idx % 5 == 1:
      # rent detail
      pass
    elif idx % 5 == 2:
      # Floor Plan, area, South-West-North-East
      pass
    elif idx % 5 == 3:
      # kind, age
      soup4 = val.find_all("div")
      for _idx, _val in enumerate(soup4):
        if _idx == 0:
          kind_array.append(_val.text)
        else:
          age_array.append(_val.text)
    elif idx % 5 == 4:
      # address
      address_array.append(val.text.strip())
    else:
      pass

  # traffic & set json
  soup5 = soup.find_all(class_ = "detailnote-box")
  for idx, val in enumerate(soup5):
   if idx % 2 == 0:
    soup6 = val.find_all("div")
    for _idx, _val in enumerate(soup6):
     traffic_array.append(
      { 
       "id":Gid2,
       "traffic":_val.text
      }
     )
    Gid2 += 1
   else:
    pass

  ### Set json
  #########################
  for idx, val in enumerate(soup1):
   #home_name = val.text.encode('utf-8')
   home_name = val.text
   home_url = fqdn + val.get('href')
   resultjson.append(
    {
     "id":Gid,
     "name":home_name,
     "url":home_url,
     "rent":rent_array[idx],
     "kind":kind_array[idx],
     "age":age_array[idx],
     "address":address_array[idx]
    }
   )
   Gid += 1
  
  sys.stdout.write("\r%d" % page_num)
  sys.stdout.flush()

### Output json
#########################
jsonfile = "./data/kanto_home_traffic.json"
f = codecs.open(jsonfile, 'w', 'utf-8')
json.dump(traffic_array, f, sort_keys=True, indent=4, ensure_ascii=False)
print("Success. Check " + jsonfile)

jsonfile = "./data/kanto_home.json"
f = codecs.open(jsonfile, 'w', 'utf-8')
json.dump(resultjson, f, sort_keys=True, indent=4, ensure_ascii=False)
print("Success. Check " + jsonfile)
