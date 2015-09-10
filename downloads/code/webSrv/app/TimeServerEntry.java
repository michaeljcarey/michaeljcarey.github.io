import java.net.ServerSocket;

public class TimeServerEntry {

	public static void main(String[] args) throws Exception {
		int clientNumber = 0;
		int portNum = 444;

		ServerSocket listener = new ServerSocket(444);
		System.out.println("Welcome to Tiny Web Server: The Socket Server is running");

		try {
			while (true) {
				new TimeServer(listener.accept(), clientNumber++).start();
			}
		} finally {
			listener.close();
		}
	}
}
