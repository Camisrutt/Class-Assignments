import javax.crypto.*;
import javax.crypto.spec.*;
import java.io.*;
import java.security.*;
import java.util.Base64;

public class demo6 {
    public static void main(String[] args) {
        try {
            // Set up password-based encryption
            String password = "abcd1234";
            byte[] salt = "12345678".getBytes(); // 8-byte salt
            int iterationCount = 1000;
            PBEParameterSpec pbeParamSpec = new PBEParameterSpec(salt, iterationCount);
            PBEKeySpec pbeKeySpec = new PBEKeySpec(password.toCharArray());
            SecretKeyFactory keyFactory = SecretKeyFactory.getInstance("PBEWithMD5AndDES");
            SecretKey secretKey = keyFactory.generateSecret(pbeKeySpec);

            // Encrypt data
            Cipher cipher = Cipher.getInstance("PBEWithMD5AndDES");
            cipher.init(Cipher.ENCRYPT_MODE, secretKey, pbeParamSpec);
            String plaintext = "We are learning Java security";
            byte[] encryptedData = cipher.doFinal(plaintext.getBytes());
            System.out.println("Encrypted text: " + Base64.getEncoder().encodeToString(encryptedData));

            // Decrypt data
            cipher.init(Cipher.DECRYPT_MODE, secretKey, pbeParamSpec);
            byte[] decryptedData = cipher.doFinal(encryptedData);
            System.out.println("Decrypted text: " + new String(decryptedData));

        } catch (Exception e) {
            System.out.println("Error: " + e.getMessage());
        }
    }
}
