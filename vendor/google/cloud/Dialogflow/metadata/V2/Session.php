<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/dialogflow/v2/session.proto

namespace GPBMetadata\Google\Cloud\Dialogflow\V2;

class Session
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Api\Annotations::initOnce();
        \GPBMetadata\Google\Api\Client::initOnce();
        \GPBMetadata\Google\Api\FieldBehavior::initOnce();
        \GPBMetadata\Google\Api\Resource::initOnce();
        \GPBMetadata\Google\Cloud\Dialogflow\V2\AudioConfig::initOnce();
        \GPBMetadata\Google\Cloud\Dialogflow\V2\Context::initOnce();
        \GPBMetadata\Google\Cloud\Dialogflow\V2\Intent::initOnce();
        \GPBMetadata\Google\Cloud\Dialogflow\V2\SessionEntityType::initOnce();
        \GPBMetadata\Google\Protobuf\Duration::initOnce();
        \GPBMetadata\Google\Protobuf\FieldMask::initOnce();
        \GPBMetadata\Google\Protobuf\Struct::initOnce();
        \GPBMetadata\Google\Rpc\Status::initOnce();
        \GPBMetadata\Google\Type\Latlng::initOnce();
        $pool->internalAddGeneratedFile(hex2bin(
            "0ac4250a28676f6f676c652f636c6f75642f6469616c6f67666c6f772f76" .
            "322f73657373696f6e2e70726f746f121a676f6f676c652e636c6f75642e" .
            "6469616c6f67666c6f772e76321a17676f6f676c652f6170692f636c6965" .
            "6e742e70726f746f1a1f676f6f676c652f6170692f6669656c645f626568" .
            "6176696f722e70726f746f1a19676f6f676c652f6170692f7265736f7572" .
            "63652e70726f746f1a2d676f6f676c652f636c6f75642f6469616c6f6766" .
            "6c6f772f76322f617564696f5f636f6e6669672e70726f746f1a28676f6f" .
            "676c652f636c6f75642f6469616c6f67666c6f772f76322f636f6e746578" .
            "742e70726f746f1a27676f6f676c652f636c6f75642f6469616c6f67666c" .
            "6f772f76322f696e74656e742e70726f746f1a34676f6f676c652f636c6f" .
            "75642f6469616c6f67666c6f772f76322f73657373696f6e5f656e746974" .
            "795f747970652e70726f746f1a1e676f6f676c652f70726f746f6275662f" .
            "6475726174696f6e2e70726f746f1a20676f6f676c652f70726f746f6275" .
            "662f6669656c645f6d61736b2e70726f746f1a1c676f6f676c652f70726f" .
            "746f6275662f7374727563742e70726f746f1a17676f6f676c652f727063" .
            "2f7374617475732e70726f746f1a18676f6f676c652f747970652f6c6174" .
            "6c6e672e70726f746f22f5020a13446574656374496e74656e7452657175" .
            "657374123a0a0773657373696f6e1801200128094229e04102fa41230a21" .
            "6469616c6f67666c6f772e676f6f676c65617069732e636f6d2f53657373" .
            "696f6e12410a0c71756572795f706172616d7318022001280b322b2e676f" .
            "6f676c652e636c6f75642e6469616c6f67666c6f772e76322e5175657279" .
            "506172616d657465727312400a0b71756572795f696e7075741803200128" .
            "0b32262e676f6f676c652e636c6f75642e6469616c6f67666c6f772e7632" .
            "2e5175657279496e7075744203e04102124a0a136f75747075745f617564" .
            "696f5f636f6e66696718042001280b322d2e676f6f676c652e636c6f7564" .
            "2e6469616c6f67666c6f772e76322e4f7574707574417564696f436f6e66" .
            "6967123c0a186f75747075745f617564696f5f636f6e6669675f6d61736b" .
            "18072001280b321a2e676f6f676c652e70726f746f6275662e4669656c64" .
            "4d61736b12130a0b696e7075745f617564696f18052001280c22f8010a14" .
            "446574656374496e74656e74526573706f6e736512130a0b726573706f6e" .
            "73655f6964180120012809123d0a0c71756572795f726573756c74180220" .
            "01280b32272e676f6f676c652e636c6f75642e6469616c6f67666c6f772e" .
            "76322e5175657279526573756c74122a0a0e776562686f6f6b5f73746174" .
            "757318032001280b32122e676f6f676c652e7270632e5374617475731214" .
            "0a0c6f75747075745f617564696f18042001280c124a0a136f7574707574" .
            "5f617564696f5f636f6e66696718062001280b322d2e676f6f676c652e63" .
            "6c6f75642e6469616c6f67666c6f772e76322e4f7574707574417564696f" .
            "436f6e66696722fc020a0f5175657279506172616d657465727312110a09" .
            "74696d655f7a6f6e6518012001280912290a0c67656f5f6c6f636174696f" .
            "6e18022001280b32132e676f6f676c652e747970652e4c61744c6e671235" .
            "0a08636f6e746578747318032003280b32232e676f6f676c652e636c6f75" .
            "642e6469616c6f67666c6f772e76322e436f6e7465787412160a0e726573" .
            "65745f636f6e7465787473180420012808124b0a1473657373696f6e5f65" .
            "6e746974795f747970657318052003280b322d2e676f6f676c652e636c6f" .
            "75642e6469616c6f67666c6f772e76322e53657373696f6e456e74697479" .
            "5479706512280a077061796c6f616418062001280b32172e676f6f676c65" .
            "2e70726f746f6275662e53747275637412650a2173656e74696d656e745f" .
            "616e616c797369735f726571756573745f636f6e666967180a2001280b32" .
            "3a2e676f6f676c652e636c6f75642e6469616c6f67666c6f772e76322e53" .
            "656e74696d656e74416e616c7973697352657175657374436f6e66696722" .
            "cb010a0a5175657279496e70757412440a0c617564696f5f636f6e666967" .
            "18012001280b322c2e676f6f676c652e636c6f75642e6469616c6f67666c" .
            "6f772e76322e496e707574417564696f436f6e666967480012350a047465" .
            "787418022001280b32252e676f6f676c652e636c6f75642e6469616c6f67" .
            "666c6f772e76322e54657874496e707574480012370a056576656e741803" .
            "2001280b32262e676f6f676c652e636c6f75642e6469616c6f67666c6f77" .
            "2e76322e4576656e74496e707574480042070a05696e7075742290050a0b" .
            "5175657279526573756c7412120a0a71756572795f746578741801200128" .
            "0912150a0d6c616e67756167655f636f6465180f2001280912250a1d7370" .
            "656563685f7265636f676e6974696f6e5f636f6e666964656e6365180220" .
            "012802120e0a06616374696f6e180320012809122b0a0a706172616d6574" .
            "65727318042001280b32172e676f6f676c652e70726f746f6275662e5374" .
            "7275637412230a1b616c6c5f72657175697265645f706172616d735f7072" .
            "6573656e7418052001280812180a1066756c66696c6c6d656e745f746578" .
            "7418062001280912480a1466756c66696c6c6d656e745f6d657373616765" .
            "7318072003280b322a2e676f6f676c652e636c6f75642e6469616c6f6766" .
            "6c6f772e76322e496e74656e742e4d65737361676512160a0e776562686f" .
            "6f6b5f736f7572636518082001280912300a0f776562686f6f6b5f706179" .
            "6c6f616418092001280b32172e676f6f676c652e70726f746f6275662e53" .
            "7472756374123c0a0f6f75747075745f636f6e7465787473180a2003280b" .
            "32232e676f6f676c652e636c6f75642e6469616c6f67666c6f772e76322e" .
            "436f6e7465787412320a06696e74656e74180b2001280b32222e676f6f67" .
            "6c652e636c6f75642e6469616c6f67666c6f772e76322e496e74656e7412" .
            "230a1b696e74656e745f646574656374696f6e5f636f6e666964656e6365" .
            "180c2001280212300a0f646961676e6f737469635f696e666f180e200128" .
            "0b32172e676f6f676c652e70726f746f6275662e53747275637412560a19" .
            "73656e74696d656e745f616e616c797369735f726573756c741811200128" .
            "0b32332e676f6f676c652e636c6f75642e6469616c6f67666c6f772e7632" .
            "2e53656e74696d656e74416e616c79736973526573756c74229c030a1c53" .
            "747265616d696e67446574656374496e74656e7452657175657374123a0a" .
            "0773657373696f6e1801200128094229e04102fa41230a216469616c6f67" .
            "666c6f772e676f6f676c65617069732e636f6d2f53657373696f6e12410a" .
            "0c71756572795f706172616d7318022001280b322b2e676f6f676c652e63" .
            "6c6f75642e6469616c6f67666c6f772e76322e5175657279506172616d65" .
            "7465727312400a0b71756572795f696e70757418032001280b32262e676f" .
            "6f676c652e636c6f75642e6469616c6f67666c6f772e76322e5175657279" .
            "496e7075744203e04102121c0a1073696e676c655f7574746572616e6365" .
            "18042001280842021801124a0a136f75747075745f617564696f5f636f6e" .
            "66696718052001280b322d2e676f6f676c652e636c6f75642e6469616c6f" .
            "67666c6f772e76322e4f7574707574417564696f436f6e666967123c0a18" .
            "6f75747075745f617564696f5f636f6e6669675f6d61736b18072001280b" .
            "321a2e676f6f676c652e70726f746f6275662e4669656c644d61736b1213" .
            "0a0b696e7075745f617564696f18062001280c22d5020a1d53747265616d" .
            "696e67446574656374496e74656e74526573706f6e736512130a0b726573" .
            "706f6e73655f696418012001280912520a127265636f676e6974696f6e5f" .
            "726573756c7418022001280b32362e676f6f676c652e636c6f75642e6469" .
            "616c6f67666c6f772e76322e53747265616d696e675265636f676e697469" .
            "6f6e526573756c74123d0a0c71756572795f726573756c7418032001280b" .
            "32272e676f6f676c652e636c6f75642e6469616c6f67666c6f772e76322e" .
            "5175657279526573756c74122a0a0e776562686f6f6b5f73746174757318" .
            "042001280b32122e676f6f676c652e7270632e53746174757312140a0c6f" .
            "75747075745f617564696f18052001280c124a0a136f75747075745f6175" .
            "64696f5f636f6e66696718062001280b322d2e676f6f676c652e636c6f75" .
            "642e6469616c6f67666c6f772e76322e4f7574707574417564696f436f6e" .
            "6669672286030a1a53747265616d696e675265636f676e6974696f6e5265" .
            "73756c7412580a0c6d6573736167655f7479706518012001280e32422e67" .
            "6f6f676c652e636c6f75642e6469616c6f67666c6f772e76322e53747265" .
            "616d696e675265636f676e6974696f6e526573756c742e4d657373616765" .
            "5479706512120a0a7472616e73637269707418022001280912100a086973" .
            "5f66696e616c18032001280812120a0a636f6e666964656e636518042001" .
            "280212440a107370656563685f776f72645f696e666f18072003280b322a" .
            "2e676f6f676c652e636c6f75642e6469616c6f67666c6f772e76322e5370" .
            "65656368576f7264496e666f12340a117370656563685f656e645f6f6666" .
            "73657418082001280b32192e676f6f676c652e70726f746f6275662e4475" .
            "726174696f6e22580a0b4d65737361676554797065121c0a184d45535341" .
            "47455f545950455f554e5350454349464945441000120e0a0a5452414e53" .
            "43524950541001121b0a17454e445f4f465f53494e474c455f5554544552" .
            "414e43451002223a0a0954657874496e70757412110a0474657874180120" .
            "0128094203e04102121a0a0d6c616e67756167655f636f64651802200128" .
            "094203e0410222680a0a4576656e74496e70757412110a046e616d651801" .
            "200128094203e04102122b0a0a706172616d657465727318022001280b32" .
            "172e676f6f676c652e70726f746f6275662e537472756374121a0a0d6c61" .
            "6e67756167655f636f64651803200128094203e0410222460a1e53656e74" .
            "696d656e74416e616c7973697352657175657374436f6e66696712240a1c" .
            "616e616c797a655f71756572795f746578745f73656e74696d656e741801" .
            "20012808225e0a1753656e74696d656e74416e616c79736973526573756c" .
            "7412430a1471756572795f746578745f73656e74696d656e741801200128" .
            "0b32252e676f6f676c652e636c6f75642e6469616c6f67666c6f772e7632" .
            "2e53656e74696d656e74222d0a0953656e74696d656e74120d0a0573636f" .
            "726518012001280212110a096d61676e697475646518022001280232bc04" .
            "0a0853657373696f6e7312a0020a0c446574656374496e74656e74122f2e" .
            "676f6f676c652e636c6f75642e6469616c6f67666c6f772e76322e446574" .
            "656374496e74656e74526571756573741a302e676f6f676c652e636c6f75" .
            "642e6469616c6f67666c6f772e76322e446574656374496e74656e745265" .
            "73706f6e736522ac0182d3e493028f0122362f76322f7b73657373696f6e" .
            "3d70726f6a656374732f2a2f6167656e742f73657373696f6e732f2a7d3a" .
            "646574656374496e74656e743a012a5a52224d2f76322f7b73657373696f" .
            "6e3d70726f6a656374732f2a2f6167656e742f656e7669726f6e6d656e74" .
            "732f2a2f75736572732f2a2f73657373696f6e732f2a7d3a646574656374" .
            "496e74656e743a012ada411373657373696f6e2c71756572795f696e7075" .
            "741292010a1553747265616d696e67446574656374496e74656e7412382e" .
            "676f6f676c652e636c6f75642e6469616c6f67666c6f772e76322e537472" .
            "65616d696e67446574656374496e74656e74526571756573741a392e676f" .
            "6f676c652e636c6f75642e6469616c6f67666c6f772e76322e5374726561" .
            "6d696e67446574656374496e74656e74526573706f6e7365220028013001" .
            "1a78ca41196469616c6f67666c6f772e676f6f676c65617069732e636f6d" .
            "d2415968747470733a2f2f7777772e676f6f676c65617069732e636f6d2f" .
            "617574682f636c6f75642d706c6174666f726d2c68747470733a2f2f7777" .
            "772e676f6f676c65617069732e636f6d2f617574682f6469616c6f67666c" .
            "6f7742c4020a1e636f6d2e676f6f676c652e636c6f75642e6469616c6f67" .
            "666c6f772e7632420c53657373696f6e50726f746f50015a44676f6f676c" .
            "652e676f6c616e672e6f72672f67656e70726f746f2f676f6f676c656170" .
            "69732f636c6f75642f6469616c6f67666c6f772f76323b6469616c6f6766" .
            "6c6f77f80101a202024446aa021a476f6f676c652e436c6f75642e446961" .
            "6c6f67666c6f772e5632ea41a5010a216469616c6f67666c6f772e676f6f" .
            "676c65617069732e636f6d2f53657373696f6e122b70726f6a656374732f" .
            "7b70726f6a6563747d2f6167656e742f73657373696f6e732f7b73657373" .
            "696f6e7d125370726f6a656374732f7b70726f6a6563747d2f6167656e74" .
            "2f656e7669726f6e6d656e74732f7b656e7669726f6e6d656e747d2f7573" .
            "6572732f7b757365727d2f73657373696f6e732f7b73657373696f6e7d62" .
            "0670726f746f33"
        ), true);

        static::$is_initialized = true;
    }
}
