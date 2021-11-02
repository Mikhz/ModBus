<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ModbusTcpClient\Network\BinaryStreamConnection;
use ModbusTcpClient\Packet\ModbusFunction\WriteSingleRegisterRequest;
use ModbusTcpClient\Packet\ModbusFunction\WriteSingleRegisterResponse;
use ModbusTcpClient\Packet\ResponseFactory;

class WriteController extends Controller
{
    public function run(Request $request){
        //echo dd($request);
        try {
            $connection = BinaryStreamConnection::getBuilder()
                ->setPort($request->port)
                ->setHost($request->ipaddress)
                ->build();

            $startAddress = (int) $request->register;
            $value = (int) $request->data; // 0x0102
            $packet = new WriteSingleRegisterRequest($startAddress, $value);
            echo 'Packet to be sent (in hex): ' . $packet->toHex() . PHP_EOL;

            $binaryData = $connection->connect()
                ->sendAndReceive($packet);
            echo 'Binary received (in hex):   ' . unpack('H*', $binaryData)[1] . PHP_EOL;

            /* @var $response WriteSingleRegisterResponse */
            $response = ResponseFactory::parseResponseOrThrow($binaryData);
            echo 'Parsed packet (in hex):     ' . $response->toHex() . PHP_EOL;
            echo 'Register value parsed from packet:' . PHP_EOL;
            print_r($response->getWord()->getInt16());

        } catch (Exception $exception) {
            echo 'An exception occurred' . PHP_EOL;
            echo $exception->getMessage() . PHP_EOL;
            echo $exception->getTraceAsString() . PHP_EOL;
        } finally {
            $connection->close();
        }

    }
}
