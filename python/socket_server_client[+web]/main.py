import asyncio
import websockets
import classes.tcp_client as client

python_server_port = 20000;
socket_server_ip = '127.0.0.1';
socket_server_port = 10000;

async def acceptClient(websocket,
                path):
    name = await websocket.recv();
    print(f"< {name}");

    greeting = f"Hello {name}!";

    await websocket.send(greeting);
    print(f"> {greeting}");

    # Send data to local Server (VIA SOCKET-CLIENT)
    client.connect (socket_server_ip,
                    socket_server_port);
    # data = 'Received connection ' + 'OJVAR';

    # client.send ('Hello User');
    # client.disconnect ();


def main ():
    # Start Web-Socket Server
    # start_server = websockets.serve(acceptClient,
    #                                 '172.20.20.143',
    #                                 20000);
    start_server = websockets.serve(hello,
                                    'localhost',
                                    python_server_port);

    asyncio.get_event_loop() \
           .run_until_complete(start_server);

    asyncio.get_event_loop() \
           .run_forever();


# Start point
if (__name__ == '__main__'):
    main ();
