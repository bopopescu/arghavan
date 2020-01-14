import socket
s_global = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
s_global.bind(("", 9090))
backlog = 0xFF
s_global.listen(backlog)
s_local = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
s_local.bind(("127.0.0.1", 9091))
s_local.listen(backlog)
