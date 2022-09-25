# jsondb
JSON-based KV database.

### db：一个数据库的管理对象。
### schema：类似MySQL的表，进行get、set、del等操作。
### LRU：针对schema的最近最多访问次数的管理，淘汰最不经常访问的schema。