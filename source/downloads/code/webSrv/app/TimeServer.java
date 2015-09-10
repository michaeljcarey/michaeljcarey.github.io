/**
 * Created by Michael J Carey on 1/30/2015.
 * Main socket concepts taken from LMU at
 * http://cs.lmu.edu/~ray/notes/javanetexamples/
 */

import java.io.*;
import java.net.ServerSocket;
import java.net.Socket;


class TimeServer extends Thread {
	TimeModel timeModel;
	SockServer sckSrv;

	/**
	 * Constructs a handler thread for a given socket.
	 * This thread will accept queries for time and will
	 * return a formatted time.
	 */
	public TimeServer(Socket _sock, int _cNum) {
		timeModel = new TimeModel();
		sckSrv = new SockServer(_sock, _cNum);
	}

	/**
	 * The run method of this thread.
	 */
	public void run() {
		System.out.println("The Time Server is running on new thread");
		// repeatedly get commands from the client and process them
		while (true) {
			String command = sckSrv.ReadLine();
			System.out.println("received from client: " + command);
			if (command == null) {
				System.out.println("breaking from while loop\n");
				break;
			}
			if (command.startsWith(":")) {
				int location = Integer.parseInt(command.substring(1));
				if (location == 1) {
					sckSrv.Println(timeModel.getCurrentDateTime());
					System.out.println("time was printed");
				} else {
					sckSrv.Println("huh? only 1 is supported.\r");
				}
			} else {
				sckSrv.Println("what? I only understand colons.\r");
			}
		}	// end while
		sckSrv.Close();
	}	// end func
}	// end class


