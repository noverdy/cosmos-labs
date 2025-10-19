CREATE TABLE IF NOT EXISTS news_articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    author VARCHAR(100) NOT NULL,
    header_image VARCHAR(500),
    category VARCHAR(50) DEFAULT 'Technology',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT NOT NULL,
    username VARCHAR(100) NOT NULL,
    comment_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (article_id) REFERENCES news_articles(id) ON DELETE CASCADE
);

INSERT INTO news_articles (title, content, author, header_image, category) VALUES
('Breaking: Major Security Conference Announced',
 'TechSec 2024 will bring together security experts from around the world to discuss the latest vulnerabilities and defense strategies. The conference will feature workshops on web security, penetration testing, and secure coding practices. Industry leaders from major tech companies will share insights on emerging threats and innovative defense mechanisms. The event expects to host over 5,000 security professionals and researchers.',
 'TechNews Staff',
 'https://picsum.photos/seed/security-conference/1200/800',
 'Cybersecurity'),

('New JavaScript Framework Gains Popularity',
 'Developers are flocking to use the new "SecureJS" framework that promises built-in XSS protection. Early adopters report positive experiences with the framework\'s intuitive API and comprehensive documentation. The framework has already gained over 50,000 GitHub stars and is being adopted by major companies for its security-first approach. Experts predict it could revolutionize frontend development.',
 'DevReporter',
 'https://picsum.photos/seed/javascript-framework/1200/800',
 'Development'),

('Local Company Implements New Security Measures',
 'CyberGuard Solutions has announced comprehensive security upgrades following recent incidents. The company has deployed advanced monitoring systems and employee training programs to prevent future security breaches. The investment represents a major commitment to data protection and customer privacy. Local officials praise the initiative as a model for other businesses in the region.',
 'LocalNews Desk',
 'https://picsum.photos/seed/business-security/1200/800',
 'Business'),

('AI Revolutionizes Healthcare Industry',
 'Artificial intelligence is transforming patient care with breakthrough diagnostic tools and personalized treatment plans. Major hospitals report 40% improvement in early disease detection using machine learning algorithms. The technology is helping doctors make more accurate diagnoses while reducing healthcare costs and improving patient outcomes.',
 'HealthTech Correspondent',
 'https://picsum.photos/seed/ai-healthcare/1200/800',
 'Healthcare'),

('Cloud Computing Market Reaches New Heights',
 'The global cloud computing market has surpassed $500 billion in annual revenue, driven by enterprise digital transformation initiatives. AWS, Azure, and Google Cloud continue to dominate the market, while smaller players focus on specialized services. Industry analysts predict continued growth as more businesses migrate to cloud infrastructure.',
 'Business Analyst',
 'https://picsum.photos/seed/cloud-computing/1200/800',
 'Business'),

('Critical Software Vulnerability Affects Millions',
 'A newly discovered zero-day vulnerability in popular software has put millions of users at risk worldwide. Security researchers are urging immediate patching as exploits have already been detected in the wild. Major tech companies are rushing to release security updates while investigating the scope of the impact.',
 'Security Alert Team',
 'https://picsum.photos/seed/vulnerability-alert/1200/800',
 'Cybersecurity'),

('Mobile App Development Trends for 2024',
 'Cross-platform development tools are gaining momentum as developers seek to build apps faster and more efficiently. React Native and Flutter lead the market, while new frameworks emerge with promising features. The industry is seeing increased demand for Progressive Web Apps and AI-powered mobile experiences.',
 'MobileDev Weekly',
 'https://picsum.photos/seed/mobile-development/1200/800',
 'Development'),

('Blockchain Technology Beyond Cryptocurrency',
 'Blockchain is finding applications beyond digital currency, with enterprises leveraging it for supply chain management, digital identity, and smart contracts. Major corporations are investing heavily in blockchain research and development. The technology promises increased transparency and security in various business processes.',
 'Tech Innovation Desk',
 'https://picsum.photos/seed/blockchain-tech/1200/800',
 'Innovation'),

('Quantum Computing Breakthrough Achieved',
 'Scientists have demonstrated quantum supremacy in a real-world application, solving complex problems in minutes that would take traditional computers thousands of years. The breakthrough brings practical quantum computing closer to reality, with potential applications in cryptography, drug discovery, and climate modeling.',
 'Science & Tech Team',
 'https://picsum.photos/seed/quantum-computing/1200/800',
 'Technology'),

('Cybersecurity Skills Gap Widens',
 'The demand for cybersecurity professionals continues to outpace supply, with over 3.5 million unfilled positions globally. Companies are increasing salaries and benefits to attract talent, while universities expand their cybersecurity programs. Experts warn the skills shortage poses a significant threat to national security.',
 'Security Careers Report',
 'https://picsum.photos/seed/cybersecurity-careers/1200/800',
 'Cybersecurity'),

('Social Media Platform Updates Privacy Policy',
 'A major social media platform has updated its privacy policy following regulatory pressure and user concerns. The changes include greater transparency about data usage and improved user controls over personal information. Privacy advocates welcome the changes but call for more comprehensive reforms.',
 'Digital Rights Watch',
 'https://picsum.photos/seed/privacy-policy/1200/800',
 'Privacy'),

('Electric Vehicle Technology Advances',
 'Breakthrough battery technology promises to extend electric vehicle range beyond 1,000 miles on a single charge. The innovation could accelerate the transition to electric transportation by addressing range anxiety concerns. Automakers are racing to integrate the new technology into their upcoming vehicle lineups.',
 'Green Tech Reporter',
 'https://picsum.photos/seed/electric-vehicle/1200/800',
 'Technology'),

('Startup Ecosystem Thrives Despite Challenges',
 'Tech startups continue to attract significant venture capital funding, with artificial intelligence and climate tech leading investment trends. While economic headwinds persist, innovative companies are finding opportunities in emerging markets and disruptive technologies. The startup ecosystem remains resilient and adaptive.',
 'VentureBeat News',
 'https://picsum.photos/seed/startup-ecosystem/1200/800',
 'Business');

INSERT INTO comments (article_id, username, comment_text) VALUES
(1, 'SecurityExpert', 'Great news! Looking forward to attending the conference. The lineup of speakers looks impressive this year.'),
(1, 'DevGuru42', 'This conference looks amazing! I hope they cover XSS prevention techniques and other security best practices.'),
(1, 'CyberWarrior', 'Attended last year and it was incredibly valuable. Highly recommend for anyone in the security field.'),
(1, 'TechStudent', 'Will there be student discounts? I\'d love to attend but on a tight budget.'),

(2, 'WebDev123', 'SecureJS sounds interesting. I wonder how it compares to existing frameworks like React and Vue in terms of performance.'),
(2, 'FrameworkFan', 'I\'ve been looking for a new JavaScript framework. The built-in security features sound promising.'),
(2, 'JavaScriptNinja', 'Finally! A framework that takes security seriously from the ground up. Can\'t wait to try it.'),
(2, 'FrontendDev', 'The API looks clean and intuitive. Hope the ecosystem grows quickly.'),

(3, 'LocalResident', 'It\'s good to see local companies taking security seriously. More businesses should follow this example.'),
(3, 'ITProfessional', 'This is exactly why security training is important for all employees, not just the IT department.'),
(3, 'BusinessOwner', 'As a small business owner, I\'m inspired to upgrade our security measures too.'),
(3, 'SecurityConsultant', 'Excellent example of proactive security management. Other companies should take note.'),

(4, 'DoctorMike', 'AI in healthcare is fascinating but we need to ensure patient data privacy remains protected.'),
(4, 'HealthTechIE', 'The potential for early disease detection is game-changing. This could save countless lives.'),
(4, 'MedicalStudent', 'Exciting times to be entering the medical field with these technological advances!'),

(5, 'CloudArchitect', 'The growth numbers are impressive but we need to focus on cloud security as adoption increases.'),
(5, 'DevOpsEngineer', 'Multi-cloud strategies are becoming essential. Good to see the market reflecting this reality.'),
(5, 'StartupCTO', 'Cloud services have made it possible for startups to compete with enterprises on infrastructure.'),

(6, 'PatchMaster', 'Everyone needs to patch immediately! This vulnerability is being actively exploited in the wild.'),
(6, 'SecurityResearcher', 'The exploitation techniques are sophisticated. This isn\'t script kiddies behind these attacks.'),
(6, 'SysAdmin2024', 'Our team worked through the weekend patching systems. Thankful for the detailed security advisories.'),

(7, 'MobileDeveloper', 'Cross-platform tools have come a long way. The performance gap is narrowing significantly.'),
(7, 'FlutterFan', 'Flutter is amazing for mobile development. The hot reload feature alone saves hours of development time.'),
(7, 'ReactNativeDev', 'React Native continues to improve with each release. The community support is incredible.'),

(8, 'BlockchainDev', 'Smart contracts are revolutionizing how we think about business agreements and automation.'),
(8, 'SupplyChainMgr', 'Blockchain for supply chain transparency is brilliant. We\'re implementing it in our company.'),
(8, 'CryptoSkeptic', 'Beyond the hype, blockchain technology does have legitimate use cases in enterprise settings.'),

(9, 'QuantumPhysicist', 'This is a monumental achievement in quantum computing. The implications are staggering.'),
(9, 'CSResearcher', 'Quantum-resistant cryptography needs to be prioritized before these systems become widely available.'),
(9, 'TechEnthusiast', 'The future is quantum! Can\'t wait to see how this transforms computing in the next decade.'),

(10, 'CybersecurityStudent', 'There\'s never been a better time to enter the cybersecurity field. The job security is incredible.'),
(10, 'HiringManager', 'We\'re struggling to find qualified candidates. The skills gap is very real and affecting our operations.'),
(10, 'SecurityTrainer', 'Our bootcamp programs are at full capacity. More people need to consider cybersecurity careers.'),

(11, 'PrivacyAdvocate', 'These changes are welcome but don\'t go far enough. Users need more control over their data.'),
(11, 'DataProtectionOfficer', 'Compliance is becoming increasingly complex. Companies need to take privacy seriously from day one.'),
(11, 'DigitalCitizen', 'Finally! I\'ve been asking for better privacy controls for years. Hope other platforms follow suit.'),

(12, 'EVEnthusiast', '1000-mile range would eliminate range anxiety completely. This is the breakthrough we\'ve been waiting for!'),
(12, 'AutoIndustryAnalyst', 'Battery technology is the key to mass EV adoption. These advances are crucial for the transition.'),
(12, 'EnvironmentalScientist', 'Extended battery life means fewer batteries needed over the vehicle lifetime, reducing environmental impact.'),

(13, 'StartupFounder', 'Despite the economic challenges, innovation continues to thrive. The ecosystem is more resilient than ever.'),
(13, 'VentureCapitalist', 'We\'re seeing more quality startups than ever before. The bar for innovation keeps rising.'),
(13, 'TechJournalist', 'The startup scene continues to be the engine of technological progress and economic growth.');