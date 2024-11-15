import java.util.Base64;
import javax.crypto.*;
import javax.crypto.spec.IvParameterSpec;

public class demo3 {
    public static void main(String[] args) {
        try {
            KeyGenerator keyGen = KeyGenerator.getInstance("DES");
            SecretKey key = keyGen.generateKey();

            // Initialize Cipher for encryption
            Cipher cipher = Cipher.getInstance("DES/CBC/PKCS5Padding");
            cipher.init(Cipher.ENCRYPT_MODE, key);
            IvParameterSpec iv = new IvParameterSpec(cipher.getIV());

            String message = "My name is Cameron Rutherford and this is for Assn 10";
            byte[] encryptedData = cipher.doFinal(message.getBytes());
            System.out.println("Encrypted message: " + Base64.getEncoder().encodeToString(encryptedData));

            // Initialize Cipher for decryption
            cipher.init(Cipher.DECRYPT_MODE, key, iv);
            byte[] decryptedData = cipher.doFinal(encryptedData);
            System.out.println("Decrypted message: " + new String(decryptedData));

        } catch (Exception e) {
            System.out.println("Error: " + e.getMessage());
        }
    }
}
