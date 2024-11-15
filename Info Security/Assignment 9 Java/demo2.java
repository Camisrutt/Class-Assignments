import java.io.*;
import java.security.*;

public class demo2 {
    public static void main(String[] args) {
        try (FileInputStream fis = new FileInputStream("demo1test");
             ObjectInputStream ois = new ObjectInputStream(fis)) {

            // Read original string and stored hash
            String s1 = (String) ois.readObject();
            byte[] originalHash = (byte[]) ois.readObject();

            // Recalculate hash
            MessageDigest md = MessageDigest.getInstance("SHA-1");
            md.update(s1.getBytes());
            byte[] recalculatedHash = md.digest();

            // Check integrity
            if (MessageDigest.isEqual(originalHash, recalculatedHash)) {
                System.out.println("Data is intact.");
            } else {
                System.out.println("Data integrity check failed.");
            }

        } catch (Exception e) {
            System.out.println("Error: " + e.getMessage());
        }
    }
}
