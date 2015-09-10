/**
 * Created by Michael J Carey on 1/30/2015.
 * Main socket concepts taken from LMU at
 * http://cs.lmu.edu/~ray/notes/javanetexamples/
 */

import java.io.*;
import java.net.Socket;


public class SockServer {
	private Socket socket;
	private BufferedReader input;
	private PrintWriter output;
	private int clientNumber;

	/**
	* Construct a socket server
	*/
	public SockServer(Socket _sock, int _cNum) {
		this.socket = _sock;
		this.clientNumber = _cNum;

		try {
			input = new BufferedReader(
							new InputStreamReader(socket.getInputStream()));
			output = new PrintWriter(socket.getOutputStream(), true);
			System.out.println("connected");
		} catch (IOException e) {
			System.out.println("socket died");
	}	}

	// accessors
	public String ReadLine() {
		try {
			return input.readLine();
		} catch (IOException e) {
			System.out.println("Error reading client# " + clientNumber + ": " + e + "\n");
		}
		return "Read Error";
	}

	public void Println(String _str) {
		output.println(_str + "\n\r");
		System.out.println("Error writing to client# " + clientNumber + "\n");
	}

	// logic
	public void Close() {
		try {
			socket.close();
		} catch (IOException e) {
			System.out.println("socket failed while closing client #  + clientNumber\n");
		}
		System.out.println("connection with client # " + clientNumber + " closed.\n");
	}	// end func

}	// end class



