# Architecture & Conceptual Model — Randomized Header Channel (RHC)

## Conceptual Diagram
```text
Client → [Random Slot Selection] → HTTP Request → Server

Headers: H1 | H2 | H3 | … | Hn
Only one header contains the valid token.
```

---

## Components

### **1. Rotation Table**
A defined list of valid headers authorized to transport the security token.

### **2. Slot Selection Algorithm**
A randomness‑driven algorithm that selects **one header slot** from `n` available channels on each request.

### **3. Token Transport**
The token is embedded into the selected header, ensuring:
- 🔒 Unpredictability
- 🛡 Reduced token‑targeting exposure
- ⚙ Compatibility with stateless + distributed systems

### **4. Validation Layer**
The server validates the request by verifying:
- ✔ The selected header exists
- ✔ The header index belongs to the rotation table
- ✔ Token signature, structure, and integrity
- ✔ Expiration, timestamps, and freshness requirements

---

## 📊 Entropy Model
```
entropy ≈ log2(n)            → number of valid header slots
+ randomness quality          → PRNG / CSPRNG
+ request frequency           → distribution of rotations
```

➡ Increasing `n` (rotation width) → increases unpredictability → strengthens resistance against replay, automation, and interception attacks.

---

## Deployment Diagram
```text
Client Application
        ↓
RHC Client Library
        ↓
API Gateway / Middleware (PSR-15)
        ↓
RHC Validation Layer
        ↓
Application Services
```

