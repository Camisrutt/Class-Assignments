import java.io.*;
import java.security.*;

public class demo1 {
    public static void main(String[] args) {
        try {
            MessageDigest md = MessageDigest.getInstance("SHA-1");
            String s1 = "My name is Cameron Rutherford and this is for Assn 10";
            byte[] array = s1.getBytes();
            
            md.update(array);
            byte[] digest = md.digest();

            // Saving the string and hash to a file
            try (FileOutputStream fos = new FileOutputStream("demo1test");
                 ObjectOutputStream oos = new ObjectOutputStream(fos)) {
                oos.writeObject(s1);
                oos.writeObject(digest);
                System.out.println("Digest created and saved successfully.");
            }
        } catch (Exception e) {
            System.out.println("Error: " + e.getMessage());
        }
    }
}
