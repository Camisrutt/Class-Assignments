import java.security.*;

public class demo5 {
    public static void main(String[] args) {
        try {
            KeyPairGenerator keyGen = KeyPairGenerator.getInstance("DSA");
            keyGen.initialize(1024, new SecureRandom());
            KeyPair keyPair = keyGen.generateKeyPair();

            PublicKey publicKey = keyPair.getPublic();
            PrivateKey privateKey = keyPair.getPrivate();
            System.out.println("Public and private keys generated.");

            // Sign data
            Signature signature = Signature.getInstance("SHA1withDSA");
            signature.initSign(privateKey);
            String data = "We are learning Java";
            signature.update(data.getBytes());
            byte[] digitalSignature = signature.sign();
            System.out.println("Data signed with private key.");

            // Verify signature
            signature.initVerify(publicKey);
            signature.update(data.getBytes());
            boolean isVerified = signature.verify(digitalSignature);
            System.out.println("Signature verification: " + (isVerified ? "valid" : "invalid"));

        } catch (Exception e) {
            System.out.println("Error: " + e.getMessage());
        }
    }
}
