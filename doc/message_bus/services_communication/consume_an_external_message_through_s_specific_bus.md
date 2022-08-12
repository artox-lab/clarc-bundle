# Consume an external message through a specific bus 

**Problem**: When you use messages from an external service, you have no idea **what the bus** will receive that message. 
In that cases messenger component will use the `fallback bus` (default messenger bus), and sometimes it's not exactly the behavior you expect.

To resolve this problem we can [configure](#configuration) what bus will process your message.

### Configuration

To route a message to a specific bus, you must implicitly assign transport to a specific bus: add your external (consuming) transport and `bus` key to transport configuration:

Edit `config/packages/artox_lab_clarc.yaml` in your project

```yaml
artox_lab_clarc:
    messenger:
        transports:
            listening:
                bus: listening.bus
```

> **Note**: Clarc bundle already have built-in `listening` transport and `listening.bus` bus and configured relation between them. You **don't need** to configure it manually.
