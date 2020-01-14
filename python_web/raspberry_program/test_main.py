import asyncio
import websockets
import classes.tcp_client as client

#pip3.8.exe install requests
#python -m pip install --upgrade pip
#pip install websockets
#pip install mysql
#pip install mysql-connector-python



python_server_port = 20000;
python_server_ip = '127.0.0.1';
socket_server_ip = '127.0.0.1';
socket_server_port = 10000;

##
## @brief      Accept User Conneciton
##
async def acceptUser(websocket,
                     path):
    print('ok');
    data = await websocket.recv();
    print('ok');
    print ('data', data);


##
## @brief      Main loop
##
def main ():
    # Start Web-Socket Server
    start_server = websockets.serve(acceptUser,
                                    python_server_ip,
                                    python_server_port);
    print('start_server');
    asyncio.get_event_loop() \
           .run_until_complete(start_server);

      
    asyncio.get_event_loop() \
           .run_forever();

# Start point
if (__name__ == '__main__'):
    main ();
